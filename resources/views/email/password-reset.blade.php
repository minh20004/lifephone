

<h1>Quên mật khẩu</h1>

<p>Xin chào {{ $name }},</p>

<p>Bạn đã yêu cầu quên mật khẩu. Vui lòng nhấp vào liên kết dưới đây để đặt lại mật khẩu:</p>

<p><a href="{{ route('password.reset', $token) }}">Đặt lại mật khẩu</a></p>

<p>Xin cảm ơn,</p>

<p>Đội ngũ {{ config('app.name') }}</p>