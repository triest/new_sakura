@if (Auth::guest())
    <a href="{{ route('lk.login') }}" class="mob personal-a">Вход</a>

    <a href="{{ route('lk.register') }}" class="mob personal-area">Регистрация</a>
@else

    <sidebar></sidebar>
@endif