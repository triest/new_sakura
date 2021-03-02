<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Близкие знакомства</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <style src="public/css/home.css"></style>
    <!-- Styles -->
    <link href="{{ asset('public/css/home.css') }}" rel="stylesheet">
    <meta name="yandex-verification" content="af4168af7d682a89"/>
    <!--icon -->
    <link rel="icon" href="<?php echo asset("images/icons/icons/favicon-16x16.png")?>" type="image/x-icon">
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">

        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">

        </div>

        <img height="350" src="<?php echo asset("/images/new.jpeg")?>">
        <div class="links">
            <br>
            <div class="links">
                <br>
                <a class="btn btn-primary" href="{{url('/login')}}"  role="link">Войти</a>
                <a class="btn btn-primary" href="{{ url('/register') }}" role="link">Зарегистрироваться</a>
            </div>

        </div>
    </div>
</div>
</body>
</html>
