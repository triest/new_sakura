@extends('layouts.lk')

@section('title', 'Профиль')

@section('content')


    <div class="container">
        <div class="profile-form">
            <div class="group">
                <a href="{{route("anket.albums",['id'=>$user->id])}}" class="personal-area">Альбомы</a>
                <a href="{{route("anket.view",['id'=>$user->id])}}" class="personal-area">Анкета</a>
            </div>



        </div>
        <div id="album_app">
            <album :user_id="{{$user->id}}" :album_id="{{$album->id}}" :owner="{{$album->canUpload()}}"></album>
        </div>

@endsection
