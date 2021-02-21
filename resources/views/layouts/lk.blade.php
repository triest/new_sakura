<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap core CSS -->



    <script src="{{ asset('public/js/app.js') }}"></script>
    <!-- Bootstrap core CSS -->

    <!-- custom buttons -->




    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">



    <!-- Bootstrap core CSS -->

    <link rel="icon" href="<?php echo asset("public/images/icons/favicon-16x16.png")?>" type="image/x-icon">


</head>

<body>
<? $city = \App\Models\City::getCurrentCity();?>
<script src="{{ asset('public/js/axios.min.js') }}"></script>
<!-- тут меню -->

<div id="app">
    @include('layouts.header')
    <div class="row">
        <div style="width: 25rem;
             border: 1px solid transparent;" class="col-sm  visible-lg">
            <event-in-my-city-side2 :city="{{$city}}"></event-in-my-city-side2>
        </div>
        <div class="col-sm-7">
            @yield('content')
        </div>
        <div class="col-sm">

        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>
