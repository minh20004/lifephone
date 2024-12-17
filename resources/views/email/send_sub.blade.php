{{-- <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <h1>{{ $subject }}</h1>
    <p>Cảm ơn bạn đã đăng ký nhận thông báo từ Lifephone!</p>
    <div>{!! $message !!}</div> <!-- Hiển thị nội dung email dưới dạng HTML -->
</body>
</html> --}}
<!DOCTYPE html>
<html>
<head>
    <title>{{ $subjectLine }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            {!! $messageBody !!}
        </div>
    </div>
</body>
</html>
