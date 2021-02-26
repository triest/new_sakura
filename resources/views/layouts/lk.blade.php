<!DOCTYPE html>
<html>
<head>

    <script src="{{ asset('public/js/app.js') }}"></script>
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
    <link rel="shortcut icon" href="/public/images/icons/favicon.ico" type="image/png">
    @if(isset($title))
    <title>{{$title}}</title>
    @else
         <title>Sakura</title>
    @endif
</head>
<!--Coded With Love By Mutiullah Samim-->
<body>
<? $city = \App\Models\City::getCurrentCity();?>
<div id="app">
    @include('layouts.header')
    <div class="row">
        <div class="col-sm-2 ">
            <event-in-my-city-side2 :city="{{$city}}"></event-in-my-city-side2>
        </div>
        <div class="col-sm-8">
            <div class="container py-5 px-4">
                @yield('content')
            </div>
        </div>
    </div>
</div>
</body>
</html>

