<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // Biến chứa thông tin đơn hàng

    /**
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    
    public function build()
    {
        return $this->subject('Xác nhận đơn hàng của bạn')
                    ->view('email.order_confirmation'); // Đường dẫn đến view email
    }
    

    
}
