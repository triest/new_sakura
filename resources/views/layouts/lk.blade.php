<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>Corp Solution - @yield('title')</title>
    <meta name="description" content="Corp Solutions - центр инновационных образовательных решений">
    <meta name="keywords" content="Corp Solutions - центр инновационных образовательных решений">

    <link rel="shortcut icon" href="/home/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/home/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/home/favicon-16x16.png">
    <link href="/home/css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="/home/css/animate.css" rel="stylesheet" type="text/css">
    <link href="/home/css/style.css" rel="stylesheet" type="text/css">
    <link href="/home/css/tablet.css" rel="stylesheet" type="text/css">
    <link href="/home/css/mobile.css" rel="stylesheet" type="text/css">




    <link rel="stylesheet" href="/home/css/bootstrap.min.css"/>

    <link rel="stylesheet" href="/home/css/cropper.css"/>

    <link rel="stylesheet" href="/home/css/modal.css"/>
    <script>let $a=[],$$=a=>a&&$a.push(a);$$.init=()=>{while($a.length)($a.shift())()}</script>
</head>
<body>

<!-- end .content-->
<header class="header">
    <div class="container-h2">
        <a href="/" class="logo"><img src="/home/img/logo.svg" alt="Corp Solutions"/></a>
        <!-- end .logo-->

        @auth
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-head').submit();"
               style="margin-right: 30px;">Выйти (ВР.)</a>
            <form id="logout-form-head" action="{{ route('lk.logout') }}" method="POST"
                  style="display: none;">@csrf</form>
        @endauth

        <a href="/" class="personal-back">На главную &RightArrow;</a>
        <!-- end .Personal-Area-->
    </div>
    <!-- end .container-->

</header>
<!-- end .header-->

@yield('content')

<footer class="footer_lk">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-12">
                <div class="copy">©2020 — CORP solutions</div>
            </div>
            <div class="col-sm-9 col-12">
                <nav class="menu">
                    <a href="#">Все курсы</a>
                    <a href="#">Вопросы и ответы</a>
                    <a href="#">Обратная связь</a>
                </nav>

                <div class="multi-language">
                    Язык: <a class="multi-language-current" href="#"><img alt="language" src="/home//img/flags_ru.png">Русский</a>
                    <ul class="multi-language-sub">
                        <li><a href="#"><img alt="language" src="/home//img/flags_ru.png">English</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="/home/js/jquery-3.5.0.min.js"></script>
<script type=" text/javascript" src="/home/js/wow.js"></script>
<script type=" text/javascript" src="/home/js/main.js"></script>
<script type=" text/javascript" src="/js/remodal.min.js"></script>

<script src="/home/js/bootstrap.min.js"></script>

<script src="/home/js/cropper.js"></script>
<script src="/js/sctipt.js"></script>
<script>$(function() {$$.init();});</script>
</body>
</html>


