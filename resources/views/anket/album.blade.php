@extends('layouts.lk')

@section('title', 'Профиль')

@section('content')


        <div class="profile-form">
            <div class="group">
                <a href="{{route("anket.albums",['id'=>$user->id])}}" class="personal-area">Альбомы</a>
                <a href="{{route("anket.view",['id'=>$user->id])}}" class="personal-area">Анкета</a>
            </div>



        </div>


            @if($album->canUpload())
               <album-owner :user_id="{{$user->id}}" :album_id="{{$album->id}}" :owner=true></album-owner>
            @else
                <album :user_id="{{$user->id}}" :album_id="{{$album->id}}" ></album>
            @endif

@endsection
