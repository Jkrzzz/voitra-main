<?php

namespace App\Console\Commands;

use App\Models\Audio;
use App\Models\SettingParam;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $audios = Audio::with('orders')->where('status', '!=', 3)->get();
        $now = Carbon::now();
        $deleteFileTime = SettingParam::where('key', 'delete_file_time')->first();
        foreach ($audios as $audio) {
            $order_p1 = $audio->orders()->where('plan', 1)->first();
            $order_p2 = $audio->orders()->where('plan', 2)->first();
            if ($order_p2) {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $order_p2->created_at)->addDays($deleteFileTime->value);
            } else {
                if (!$order_p1){
                    continue;
                }
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $order_p1->created_at)->addDays($deleteFileTime->value);
            }
            if ($now > $date) {
                $array = explode('/', $audio->url);
                Storage::delete('audios/' . end($array));
                $audio->status = 3;
                $audio->deleted_at = $now->format('Y-m-d H:i:s');
                $audio->url = '';
                $audio->api_result = null;
                $audio->result = null;
                $audio->edited_result = null;
                $audio->save();
            }
        }
        return 0;
    }
}
