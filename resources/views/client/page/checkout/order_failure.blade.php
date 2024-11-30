<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Thất Bại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-container {
            margin-top: 50px;
            text-align: center;
            color: #dc3545;
        }
        .error-icon {
            font-size: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="error-container">
        <div class="error-icon">
            <i class="bi bi-x-circle-fill"></i>
        </div>
        <h1>Thanh Toán Thất Bại!</h1>
        <p>Rất tiếc, giao dịch của bạn không thành công. Vui lòng thử lại.</p>
        <p class="text-muted">Lý do: {{ $errorMessage ?? 'Lỗi không xác định' }}</p>
        <a href="{{ route('checkout') }}" class="btn btn-danger mt-4">Thử lại</a>
        <a href="{{ route('home') }}" class="btn btn-secondary mt-4">Quay về trang chủ</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
