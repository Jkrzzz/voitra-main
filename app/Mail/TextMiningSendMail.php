<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;


class TextMiningSendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $company;
    public $name;
    public $phone;
    public $email;
    public $text;
    public $date;
    public $plan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->company = $request->company;
        $this->name = $request->name;
        $this->phone = $request->phone;
        $this->email = $request->email;
        $this->text = $request->text;
        $this->plan = $request->plan;
        $this->date = Carbon::now();
        $this->date->setTimezone('Japan');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        return $this->from('support@voitra.jp', env('MAIL_FROM_NAME', ''))->subject('【voitra 対応】プラン３お問い合わせがありました')->view('user.plan-3-mail');
    }
}
