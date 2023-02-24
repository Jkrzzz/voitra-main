<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemoveMemberAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $survey;

    public $survey_content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$survey, $survey_content)
    {
        $this->user = $user;
        $this->survey = $survey;
        $this->survey_content = $survey_content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('【voitra】 アンケート】退会のアンケート')
            ->view('emails.remove_member_admin');
    }
}
