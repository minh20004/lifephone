<?php
namespace App\Http\Controllers;

use App\Models\SentEmail;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    // Hiển thị danh sách email đăng ký
    public function index()
    {
        $subscriptions = Subscription::latest()->paginate(10);
        return view('admin.page.subscription.sub', compact('subscriptions'));
    }

    // Lưu email từ form
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        Subscription::create([
            'email' => $request->email,
        ]);

        Mail::raw('Lifephone cảm ơn bạn đã quan tâm! Hãy để lại thắc mắc, chúng tôi sẽ giải đáp.', function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Cảm ơn bạn đã đăng ký nhận thông báo');
        });

        return redirect()->back()->with('success', 'Đăng ký nhận thông báo thành công!');
    }

    // Xóa email đăng ký
    public function destroy($id)
    {
        Subscription::findOrFail($id)->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Xóa email thành công!');
    }


    public function sentEmails()
    {
        $sentEmails = SentEmail::latest()->paginate(10);  // Lấy dữ liệu các email đã gửi từ bảng SentEmail
        return view('admin.page.subscription.index', compact('sentEmails'));  // Trả về view hiển thị các email đã gửi
    }

    public function create()
    {
    return view('admin.page.subscription.send');  // Trỏ tới view form gửi email
    }
    
    // Phương thức gửi email hàng loạt
    public function sendBulkEmails(Request $request)
    {
        // Kiểm tra dữ liệu gửi lên
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Lưu thông tin email đã gửi vào bảng sent_emails
        $sentEmail = SentEmail::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'sent_at' => now(),
        ]);

        // Lấy tất cả email từ cơ sở dữ liệu
        $subscriptions = Subscription::all();

        // Gửi email cho từng người đăng ký
        foreach ($subscriptions as $subscription) {
            Mail::raw($request->message, function ($message) use ($subscription, $request) {
                $message->to($subscription->email)
                        ->subject($request->subject);
            });
        }

        // Chuyển hướng với thông báo thành công
        return redirect()->route('subscriptions.index')->with('success', 'Email đã được gửi đến tất cả người đăng ký!');
    }

    public function show($id)
    {
        // Lấy thông tin chi tiết của email đã gửi
        $sentEmail = SentEmail::findOrFail($id);

        // Trả về view với thông tin chi tiết email
        return view('admin.page.subscription.show', compact('sentEmail'));
    }

}
