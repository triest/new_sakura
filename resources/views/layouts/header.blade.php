<nav class="navbar navbar-light bg-light" id="headerApp">
    <a class="navbar-brand">Navbar</a>
    <div style="display:inline">
        @auth
            <sidebar :user="{{auth()->user()}}"></sidebar>
        @endauth

        @guest
                <b><a class="button blue" href="{{ url('/login') }}">Войти</a></b>
                <b><a class="button green" href="{{ url('/join') }}">Зарегистрироваться</a></b>
        @endguest
    </div>
</nav>
