@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', "Карусель лайков")
@section('content')
    <div class="container">
        <div class="profile-form">
            <a class="btn btn-primary" href="{{route("anket.main")}}">К списку анкет</a>
            <like-carusel></like-carusel>
        </div>
    </div>

@endsection