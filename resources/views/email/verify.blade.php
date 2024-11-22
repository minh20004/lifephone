<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận tài khoản</title>
</head>
<body>
    <h1>Xác nhận tài khoản của bạn</h1>
    <p>Vui lòng nhấp vào liên kết bên dưới để xác nhận tài khoản:</p>
    <a href="{{ route('customer.verify', $token) }}">Xác nhận tài khoản</a>
</body>
</html>
