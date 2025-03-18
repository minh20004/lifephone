<?php

// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;
// use App\Models\Customer;

// class VerifyEmail extends Mailable
// {
//     use SerializesModels;

//     public $customer;

//     public function __construct(Customer $customer)
//     {
//         $this->customer = $customer;
//     }

//     public function build()
//     {
//         $verificationUrl = route('customer.verify', ['token' => $this->customer->verification_token]);

//         return $this->view('email.verify')  // View sẽ chứa nội dung email
//                     ->with([
//                         'customerName' => $this->customer->name,
//                         'verificationUrl' => $verificationUrl,
//                     ])
//                     ->subject('Xác nhận tài khoản của bạn');
//     }
// }
namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $token;

    /**
     * Tạo một instance mới của thông điệp.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->token = $customer->verification_token; // Lấy token xác nhận từ khách hàng
    }

    /**
     * Xây dựng thông điệp email.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Xác nhận tài khoản của bạn')
                    ->view('email.verify')
                    ->with([
                        'token' => $this->token,
                        'email' => $this->customer->email,
                    ]);
    }
}
