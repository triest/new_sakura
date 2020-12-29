<nav class="navbar  bg-light" id="headerApp" style="margin-left: auto;margin-right: auto">
    <span class="d-flex justify-content-center" style="display:inline;text-align: center;">
        @auth
            <sidebar :user="{{auth()->user()}}" style="margin-left: auto;margin-right: auto"></sidebar>
        @endauth

        @guest
            <div class="d-flex justify-content-center">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <b><a class="button blue" href="{{ url('/login') }}">Войти</a></b>
            <b><a class="button green" href="{{ url('/join') }}">Зарегистрироваться</a></b>
            </nav>
            </div>
        @endguest
    </span>
</nav>
