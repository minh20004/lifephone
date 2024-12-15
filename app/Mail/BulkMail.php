<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class BulkMail extends Mailable
{
    public $subjectLine;
    public $messageBody;

    public function __construct($subjectLine, $messageBody)
    {
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('email.send_sub') // Tạo view cho email
                    ->with([
                        'messageBody' => $this->messageBody,
                    ]);
    }
}
