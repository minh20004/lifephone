<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận thay đổi email</title>
</head>
<body>
    <p>Xin chào,</p>
    <p>Bạn đã yêu cầu thay đổi email tài khoản của mình. Vui lòng nhấn vào liên kết bên dưới để xác nhận:</p>
    <a href="{{ route('customer.verifyEmailChange', $token) }}">Xác nhận thay đổi email</a>
    <p>Nếu bạn không yêu cầu thay đổi này, vui lòng bỏ qua email này.</p>
</body>
</html>
