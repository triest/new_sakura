@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', "Мои лайки")
@section('content')
    <div class="col-lg-3 col-md-5 col-sm-6  justify-content-center col-xs-9 box-shadow"
         style="padding-left:60px; padding-right: 20px;margin: auto;">
        @foreach($likes as $like)
            <img src="{{asset( "$like->blur_photo_profile_url")}}" height="250px" width="250px">
            {{$like->name}}
        @endforeach
    </div>

@endsection
