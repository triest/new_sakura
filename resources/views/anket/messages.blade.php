@extends('layouts.lk', ['title'=>"Сообщения"])

@section('title', "Сообщения")
@section('content')

        <chat-app :user="{{auth()->user()}}"    @if($user) :target_user="{{$user}}"  @endif></chat-app>

@endsection
