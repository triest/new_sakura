@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', "Карусель лайков")
@section('content')
    <div id="app" class="container">
        <div class="profile-form">
            <a class="btn btn-primary" href="{{route("anket.main")}}">К списку анкет</a>
            <like-carousel></like-carousel>
        </div>
    </div>

@endsection
