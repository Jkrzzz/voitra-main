<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            'name' => "話者分離オプション",
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('setting_params')->insert([
            'key' => "diarization_trail",
            'name' => '話者分離無料キャンペーン',
            'value' => "1",
            'expired_date' => '',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('setting_params')->insert([
            'key' => "time_processing_daily",
            'value' => 18000,
            'name' => '一日処理可能な音声の合計時間の設定',
            'expired_date' => '',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('setting_params')->insert([
            'key' => "time_end_daily",
            'value' => '23:59',
            'name' => '終業時間',
            'expired_date' => '',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('setting_params')->insert([
            'key' => "day_delay",
            'value' => 2,
            'name' => 'デフォルトまでの最低日数設定',
            'expired_date' => '',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('setting_params')->insert([
            'key' => "audio_duration",
            'value' => 3600,
            'name' => 'アップする音声の長さ',
            'expired_date' => '',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('setting_params')->insert([
            'key' => "day_off",
            'value' => json_encode([]),
            'name' => '案件対応不可日付を設定',
            'expired_date' => '',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('setting_params')->insert([
            'key' => "delete_file_time",
            'value' => 31,
            'name' => 'サーバー上の音声ファイル保存期間設定',
            'expired_date' => '',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
}
