<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Storage\StorageClient;
use GPBMetadata\Google\Cloud\Speech\V1\CloudSpeech;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class RecognitionService
{
  public function recognition($audioPath, $languageCode)
  {
    $bucket = env('GOOGLE_CLOUD_STORAGE_BUCKET');
    $sampleRateHertz = 16000;
    // $ffmpeg = FFMpeg::create([
    //   'ffmpeg.binaries' => '/usr/bin/ffmpeg',
    //   'ffprobe.binaries' => '/usr/bin/ffprobe'
    // ]);
    $audioPath = Storage::path('audios/' . basename($audioPath));
    // $audioFormat = $ffmpeg->open($audioPath);
    try {
      $storage = new StorageClient();
      $storage->bucket($bucket)->upload(fopen($audioPath, 'r'));
      $encoding = AudioEncoding::FLAC;
      $config = new RecognitionConfig();
      $config->setEncoding($encoding);
      $config->setLanguageCode($languageCode);
      $config->setEnableWordTimeOffsets(true);
      // $config->setSampleRateHertz($sampleRateHertz);
      $filename = basename($audioPath);
      $audio = new RecognitionAudio();
      $audio->setUri('gs://' . $bucket . '/' . $filename);
      $speechClient = new SpeechClient();
      $operationResponse = $speechClient->longRunningRecognize($config, $audio);
      $speechClient->close();
      $isComplete = $operationResponse->isDone();

      while (!$isComplete) {
        sleep(1);
        $operationResponse->reload();
        $isComplete = $operationResponse->isDone();
      }
      $result = $operationResponse->getResult();
      return $result;
    } catch (\Exception $e) {
      return NULL;
      // return response()->json($e->getMessage(), 400);
    }
  }

  public function recognize($audioId, $audioPath, $languageCode, $diarization, $spk, $callback, $wait)
  {
    try {

      $curl = curl_init();
      $audioPath = Storage::path('audios/' . basename($audioPath));
      curl_setopt_array($curl, array(
        CURLOPT_URL => config('speech2text.stt_api_url'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
          'file' => new \CURLFile($audioPath),
          'number' => $spk,
          'lang' => $languageCode,
          'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c',
          'diarization' => $diarization,
          'audio_id' => $audioId,
          'callback' => $callback,
          'wait' => $wait
        )
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      return json_decode($response);
    } catch (\Exception $e) {
      return NULL;
    }
  }
}
