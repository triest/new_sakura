@extends('layouts.lk')
@section('title', "Сообщения")
@section('content')
    <a class="button blue" href="{{route('anket.main')}}" role="link"><i class="fa fa-arrow-left"></i> К списку
        анкет</a>
    <div class="card">
        <div class="card-body" id="app">
                <chat-app :user="{{auth()->user()}}"></chat-app>
        </div>
    </div>


@endsection