<?php
namespace App\Helper;

class Helper
{
    public static function formatDuration($time) {
        if ($time > 0){
            $hours = floor($time / 3600);
            $minutes = floor(($time / 60) % 60);
            $seconds = $time % 60;

            return ($hours > 9 ? $hours : '0' . $hours) . '時間' . ($minutes > 9 ? $minutes : '0' . $minutes) . '分' . ($seconds > 9 ? $seconds : '0' . $seconds) . '秒';
        } else {
            return '00時間00分00秒';
        }
    }
    public static function secondsFromTime($time) {
        list($h, $m) = explode(':', $time);
        return ($h * 3600) + ($m * 60);
    }
    public static function secondsToMinutes($seconds) {
        return ($seconds / 60);
    }
}
