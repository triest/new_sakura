<nav class="navbar  bg-light">
    <span class="d-flex justify-content-center" style="display:inline;text-align: center; margin-left: auto; margin-right: auto">

        @auth
            <sidebar :user="{{auth()->user()}}" style="margin-left: auto;margin-right: auto"></sidebar>
        @endauth

        @guest
            <div class="d-flex justify-content-center">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <b><a class="btn btn-primary" href="{{ url('/login') }}">Войти</a></b> &nbsp;
            <b><a class="btn btn-secondary" href="{{ url('/register') }}">Зарегистрироваться</a></b>
            </nav>
            </div>
        @endguest
    </span>
</nav>
