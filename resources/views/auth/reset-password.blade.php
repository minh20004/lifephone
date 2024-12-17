

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="password" name="password" placeholder="Mật khẩu mới">
    <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu mới">
    <button type="submit">Reset mật khẩu</button>
</form>