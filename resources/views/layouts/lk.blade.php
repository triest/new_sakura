<!DOCTYPE html>
<html>
<head>

    <script src="{{ asset('public/js/app.js') }}"></script>
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
</head>
<!--Coded With Love By Mutiullah Samim-->
<body>
<? $city = \App\Models\City::getCurrentCity();?>
<div id="app">
    @include('layouts.header')

    <div style="width: 25rem;
             border: 1px solid transparent;" class="visible-lg">
        <event-in-my-city-side2 :city="{{$city}}"></event-in-my-city-side2>
    </div>
    <div class="container py-5 px-4">


        @yield('content')
    </div>

</div>
</body>
</html>

