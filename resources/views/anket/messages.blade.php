@extends('layouts.lk')
@section('title', "Сообщения")
@section('content')
    <div class="container" id="app">
        <a class="button blue" href="{{route('anket.main')}}" role="link"><i class="fa fa-arrow-left"></i> К списку
            анкет</a>

                <chat-app :user="{{auth()->user()}}"></chat-app>

    </div>


@endsection