<nav class="navbar  bg-light" id="headerApp" style="margin-left: auto;margin-right: auto">
    <span style="display:inline">
        @auth
            <sidebar :user="{{auth()->user()}}"></sidebar>
        @endauth

        @guest
            <b><a class="button blue" href="{{ url('/login') }}">Войти</a></b>
            <b><a class="button green" href="{{ url('/join') }}">Зарегистрироваться</a></b>
        @endguest
    </span>
</nav>
