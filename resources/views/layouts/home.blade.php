<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>@yield('title')</title>
    <meta name="description" content="Corp Solutions - центр инновационных образовательных решений">
    <meta name="keywords" content="Corp Solutions - центр инновационных образовательных решений">

    <link rel="shortcut icon" href="/home/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/home/favicon-32x32.png">
    <link rel="icon" type="/image/png" sizes="16x16" href="/home/favicon-16x16.png">

    <link href="/home/css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="/home/css/animate.css" rel="stylesheet" type="text/css">
    <link href="/home/css/style.css" rel="stylesheet" type="text/css">
    <link href="/home/css/tablet.css" rel="stylesheet" type="text/css">
    <link href="/home/css/mobile.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
    <script src="/home/js/html5shiv.min.js"></script>
    <script src="/home/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- end .content-->
<header class="header">
    <div class="container-h">
        <a href="/" class="logo"><img src="/home/img/logo.svg" alt="Corp Solutions"/></a>
        <!-- end .logo-->
        <nav class="menu">
            <a href="collections.html">Plaseholder</a>
            <a href="{{ route('lesson') }}">Plaseholder</a>
            <a href="#">Plaseholder</a>
            <a href="#">Plaseholder</a>
            <a href="#">Plaseholder</a>


            <a href="{{ route('admin.register') }}" class="mob personal-a">Вход</a>

            <a href="{{ route('lk.login') }}" class="mob personal-a">Вход</a>

            <a href="{{ route('lk.register') }}" class="mob personal-area">Регистрация</a>

        </nav>
        <!-- end .menu-->
        <div class="toggle-menu"><span class="pos1"></span> <span class="pos2"></span> <span class="pos3"></span>
        </div>
        <!-- end .toggle-menu-->
        <a href="{{ route('lk.login') }}" class="personal-a">Вход</a>
        <a href="{{ route('lk.register') }}" class="personal-area">Регистрация</a>
        <!-- end .Personal-Area-->
    </div>

</header>
<!-- end .header-->

@yield('content')

<footer class="footer">
    <div class="relative">
        <div class="container-f">
            <a href="/" class="logo"><img src="/home/img/logo.svg" alt="Corp Solutions"/></a>
            <!-- end .logo-->
            <nav class="menu">
                <a href="#">Plaseholder</a>
                <a href="#">Plaseholder</a>
                <a href="#">Plaseholder</a>
                <a href="#">Plaseholder</a>
                <a href="#">Plaseholder</a>
            </nav>

            <div class="social">
                <a href="#" class="item"><img src="/home/img/insta.svg" alt=".."></a>
                <a href="#" class="item"><img src="/home/img/vk.svg" alt=".."></a>
                <a href="#" class="item"><img src="/home/img/fb.svg" alt=".."></a>
            </div>
        </div>
    </div>

    <div class="conf2">
        <div class="lang">
            <div class="multi-language">
                Язык: <a class="multi-language-current" href="#"><img alt="language" src="/home/img/flags_ru.png">Русский</a>
                <ul class="multi-language-sub">
                    <li><a href="#"><img alt="language" src="/home/img/flags_ru.png">English</a></li>
                </ul>
            </div>
        </div>
        <div class="copy">
            ©2020 —Plaseholder
        </div>
    </div>
</footer>

<script src="/home/js/jquery-3.5.0.min.js"></script>
<script src="/home/js/wow.js"></script>
<script src="/home/js/main.js"></script>
</body>
</html>