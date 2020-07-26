<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>@yield('title')</title>
    <meta name="description" content="Corp Solutions - центр инновационных образовательных решений">
    <meta name="keywords" content="Corp Solutions - центр инновационных образовательных решений">
    <link rel="icon" href="<?php echo asset("images/icons/favicon.png")?>" type="image/x-icon">
    <link href="/home/css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="/home/css/animate.css" rel="stylesheet" type="text/css">
    <link href="/home/css/style.css" rel="stylesheet" type="text/css">
    <link href="/home/css/tablet.css" rel="stylesheet" type="text/css">
    <link href="/home/css/mobile.css" rel="stylesheet" type="text/css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/home/css/bootstrap.min.css"/>

    <link rel="stylesheet" href="/home/css/cropper.css"/>

    <link rel="stylesheet" href="/home/css/modal.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script>let $a = [], $$ = a => a && $a.push(a);
        $$.init = () => {
            while ($a.length) ($a.shift())()
        }</script>
</head>
<body>

<?
$city = App\Models\City::GetCurrentCity(); ?>
<!-- end .content-->
<div id="headerApp">
    @include('lk.header')
</div>
<!-- end .header-->
<div id="app" class="container">

    <div class="row">
        <div class="col-sm-2">
            <event-in-my-city-side :city="{{$city}}"></event-in-my-city-side>
        </div>

        <div class="col-sm-8">
            @yield('content')
        </div>
        <div class="col-sm-1">
            @include('lk.sidebar')
        </div>
    </div>
</div>
<footer class="footer_lk">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-12">
                <div class="copy"></div>
            </div>
            <div class="col-sm-9 col-12">
                <nav class="menu">
                    <a href="#"></a>
                    <a href="#"></a>
                    <a href="#"></a>
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
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>

<script type=" text/javascript" src="/home/js/wow.js"></script>
<script type=" text/javascript" src="/home/js/main.js"></script>
<script type=" text/javascript" src="/js/remodal.min.js"></script>

<script src="/home/js/bootstrap.min.js"></script>

<script src="/home/js/cropper.js"></script>
<script src="/js/script.js"></script>
<script>$(function () {
        $$.init();
    });</script>
</body>
</html>


