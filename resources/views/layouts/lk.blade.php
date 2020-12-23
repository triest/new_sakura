<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('title')</title>
    <script src="https://getbootstrap.com/docs/3.3/assets/js/ie-emulation-modes-warning.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap core CSS -->

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/gallery-grid.css')}}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Bootstrap core CSS -->

    <!-- custom buttons -->


    <!--for galeray -->
    <link href="{{asset('css/gallery-grid.css')}}">

    <!--end for faleray -->

    <!--My custom style -->
    <link href="{{asset('css/style.css')}}" type="text/css">
    <!-- -->
    <link href="{{asset('css/app.css')}}" type="text/css">

    <link href="{{asset('css/carusel.css')}}" type="text/css">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"
          rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">

    <link rel="icon" href="<?php echo asset("images/icons/icons/favicon-16x16.png")?>" type="image/x-icon">

</head>

<body>
<!-- тут меню -->
@include('layouts.header')
<script src="{{ asset('js/axios.min.js') }}"></script>
<?
$city = \App\Models\City::getCurrentCity();
?>



<div class="col-sm-1">
    <div id="event_in_my_city_side_app" class="visible-xs visible-lg" style="width: 25rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;">
        @isset($city)
            <? if($city){ ?>
            <event-in-my-city-side2 :city="{{$city}}"></event-in-my-city-side2>
            <?}?>
        @endisset
    </div>
</div>
<div class="col-sm-1">
</div>
<div class="col-sm-8">
    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-sm-12">
            <p class="pull-right visible-xs visible-lg">
                <!--  <button type="button" class="menuButton" data-toggle="offcanvas"><b>Меню</b></button> -->
                <button type="button" class="navbar-toggle collapsed js-offcanvas-btn">
                    <span class="sr-only"><a href="{{ url('/logout') }}">Выйти</a></span>
                    <span class="hiraku-open-btn-line"></span>
                </button>
            </p>

            <div class="row" style="z-index: -100">
                @yield('content')
            </div><!--/row-->
        </div><!--/span-->
        <!--sm- комп -->
        <div class=" col-sm-2 sidebar-offcanvas  hidden-xs" id="sidebar" role="navigation">
            <div class="card-body">
                <!-- <p class="pull-right visible-xs visible-sm">
                     <button type="button" class="menuButton" data-toggle="offcanvas"><b>Закрыть</b></button>
                 </p>
                 -->


            </div>
        </div>
    </div><!--/span-->
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!--<script src="http://bootstrap-3.ru/dist/js/bootstrap.min.js"></script>-->

<script src="http://bootstrap-3.ru/examples/offcanvas/offcanvas.js"></script>

</body>
</html>
<script>
    import EventInMyCitySide2 from "../../js/components/events/EventInMyCitySide2";

    export default {
        components: {EventInMyCitySide2}
    }
</script>
