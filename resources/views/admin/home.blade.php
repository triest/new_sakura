@extends('layouts.admin')

@section('title', 'Рабочий стол')

@section('content')
    <div class="container" id="app">
        <div class="profile-form">
            выбирите пункт меню

            <a class="btn btn_les" href="{{route('admin.presents.main')}}"> Настройка подарков</a>
            <a class="btn btn_les"  href="{{route('admin.anket.main')}}"> Настройка анкеты</a>
            <a class="btn btn_les" href="{{route('admin.price.main')}}"> Настройка цен</a>
        </div>
    </div>
@endsection
