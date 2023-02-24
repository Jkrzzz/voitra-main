<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ServiceProvider  extends Controller
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public static function spk2id($data) {
        $spks = array();
        $res = array();
        foreach($data as $item) {
            if (!in_array($item->speaker, $spks)) {
                array_push($spks, $item->speaker);
            }
        }
        foreach($spks as $spk){
                $res[$spk] = $spk;
        }
        return $res;
    }

}
