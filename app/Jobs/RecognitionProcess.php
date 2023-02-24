<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Audio;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\SendMail;

class RecognitionProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_id)
    {
        //
        $this->order_id = $order_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bucket = env('GOOGLE_CLOUD_STORAGE_BUCKET');
        $storage = new StorageClient();
        $orderInfo = Order::find($this->order_id);
        $listOper = array();
        // dd($orderInfo->user);

        foreach ($orderInfo->audios as $audioD) {
            $audioPath = Storage::path('audios/' . basename($audioD->url));
            try {
                $storage->bucket($bucket)->upload(fopen($audioPath, 'r'));
                $encoding = AudioEncoding::FLAC;
                $config = new RecognitionConfig();
                $config->setEncoding($encoding);
                $config->setLanguageCode($audioD->language);
                $config->setEnableWordTimeOffsets(true);
                // $config->setSampleRateHertz($sampleRateHertz);
                $filename = basename($audioPath);
                $audio = new RecognitionAudio();
                $audio->setUri('gs://' . $bucket . '/' . $filename);
                $speechClient = new SpeechClient();
                $operationResponse = $speechClient->longRunningRecognize($config, $audio);
                array_push($listOper, ['audio' => $audioD['id'], 'operator' => $operationResponse]);
                $speechClient->close();
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
        foreach ($listOper as $operate) {
            $operator = $operate['operator'];
            $isComplete = $operator->isDone();
            while (!$isComplete) {
                sleep(1);
                $operator->reload();
                $isComplete = $operator->isDone();
            }
            $text = '';
            $audio = Audio::find($operate['audio']);
            try {
                $result = $operator->getResult();
                $result = json_decode($result->serializeToJsonString(), true);
                foreach ($result['results'] as $result) {
                    foreach ($result['alternatives'] as $txt) {
                        $text = $text . $txt['transcript'];
                    }
                }
                $audio->api_result = $text;
                $rel = $orderInfo->audios()->find($operate['audio']);
                $rel->pivot->status = 2;
                $rel->pivot->save();
                $audio->status = 2;
                $audio->save();
            } catch (\Exception $e) {
                $audio->api_result = $text;
                $rel = $orderInfo->audios()->find($operate['audio']);
                $rel->pivot->status = 3;
                $rel->pivot->save();
                $audio->save();
                Log::error($e->getMessage());
            }
        }
        $orderInfo->status = 2;
        $orderInfo->save();
        Mail::to($orderInfo->user->email)->send(new SendMail(['user' => $orderInfo->user, 'order' => $orderInfo], '【voitra】AI文字起こしプラン テキスト化完了のお知らせ', 'emails.recognize_success'));
    }
}
