<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestMail extends Mailable
{
    use Queueable, SerializesModels;

    private $sender;
    private $sendFrom;
    public $subject;
    private $contents;

    /**
     * Create a new message instance.
     *
     * @param string $sender_name 보내는 사람 이름
     * @param string $sender_email 보내는 사람 이메일
     * @param string $subject 제목
     * @param string $contents 내용
     */
    public function __construct($sender, $sendFrom, $subject, $contents)
    {
        $this->sender = $sender;
        $this->sendFrom = $sendFrom;
        $this->subject = $subject;
        $this->contents = $contents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->with([
                'sender' => $this->sender,
                'sendFrom' => $this->sendFrom,
                'contents' => $this->contents,
            ])
            ->view('emails.request');
    }
}
