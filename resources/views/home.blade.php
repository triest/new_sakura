@extends('layouts.home2')

@section('content')
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())

            @else
                <a href="{{ url('/login') }}">Войти</a>
                <a href="{{ url('/join') }}">Зарегистрироваться</a>
            @endif
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
                <a class="button green" href="" value="Смотреть анкеты" role="link">Смотреть анкеты</a>
                <a class="button blue" href="" value="Смотреть анкеты" role="link">Разместить
                    анкету</a>
            </div>

        </div>
    </div>
@endsection
