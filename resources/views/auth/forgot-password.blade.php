<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="Email">
    <button type="submit">Gửi yêu cầu</button>
</form>