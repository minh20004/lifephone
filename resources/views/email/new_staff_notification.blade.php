<!DOCTYPE html>
<html>
<head>
    <title>Mail xác nhận tài khoản</title>
</head>
<body>
    <h1>Xin chào {{ $user->name }}</h1>
    <p>Bạn đã được thêm vào hệ thống với vai trò {{ $user->role }}.</p>
    <p>Email: {{ $user->email }}</p>
    <p>Vui lòng nhấn vào liên kết dưới đây để xác nhận tài khoản của bạn:</p>
    {{-- <a href="{{ route('verification.verify', ['token' => $verificationToken]) }}">Xác nhận tài khoản</a> --}}
    {{-- <a href="{{ route('verification.verify', ['id' => $user->id, 'hash' => sha1($user->email)]) }}">Xác nhận tài khoản</a> --}}
    <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
    <p>Mật khẩu của bạn đã được thiết lập, vui lòng đăng nhập để thay đổi.</p>
    <p>Cảm ơn bạn!</p>
</body>
</html>