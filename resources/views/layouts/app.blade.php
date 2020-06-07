<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>@yield('title') - Corp Solution</title>
    <meta name="description" content="Corp Solutions - центр инновационных образовательных решений">
    <meta name="keywords" content="Corp Solutions - центр инновационных образовательных решений">
    <link rel="icon" href="{{ URL::asset('images/icons/favicon-16x16.png') }}" type="image/x-icon"/>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('css/tablet.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>


    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>


    <![endif]-->
</head>
<body>

<!-- end .content-->
<header class="header">
    <div class="container-h">
        <a href="/" class="logo"><img src="/img/logo.svg" alt="Corp Solutions"/></a>
        <!-- end .logo-->


        <a href="/" class="personal-back">На главную &RightArrow;</a>
        <!-- end .Personal-Area-->
    </div>
    <!-- end .container-->

</header>
<!-- end .header-->

<div class="container">
    @yield('content')
</div>


<footer class="footer">
    <div class="relative">
        <div class="container-f">
            <a href="/" class="logo"><img src="/img/logo.svg" alt="Corp Solutions"/></a>
            <!-- end .logo-->
            <nav class="menu">
                <a href="#">Обучение</a>
                <a href="#">Проекты</a>
                <a href="#">СДОТ</a>
                <a href="#">Тренеры</a>
                <a href="#">Контакты</a>

            </nav>

            <div class="social">
                <a href="#" class="item"><img src="/img/insta.svg" alt=".."></a>
                <a href="#" class="item"><img src="/img/vk.svg" alt=".."></a>
                <a href="#" class="item"><img src="/img/fb.svg" alt=".."></a>
            </div>
        </div>
    </div>

    <div class="conf2">
        <div class="lang"></div>
        <div class="copy">
            ©2020 — CORP solutions
        </div>
    </div>
</footer>

<script type=" text/javascript" src="js/jquery-3.5.0.min.js"></script>
<script type=" text/javascript" src="js/wow.js"></script>
<script type=" text/javascript" src="js/main.js"></script>
</body>
</html>
