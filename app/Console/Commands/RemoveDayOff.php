<?php

namespace App\Console\Commands;

use App\Models\SettingParam;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemoveDayOff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:dayOff';

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
        $dayOffs = SettingParam::where('key','day_off')->first();
        $value = json_decode($dayOffs->value, 1);
        $now = Carbon::now();
        foreach ($value as $key => $el) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s',  $el .' 23:59:59');
            if ($date < $now) {
                unset($value[$key]);
            }
        }
        $dayOffs->value = json_encode($value);
        $dayOffs->save();
        return 0;
    }
}
