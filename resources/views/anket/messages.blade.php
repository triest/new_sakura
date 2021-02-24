@extends('layouts.lk')
@section('title', "Сообщения")
@section('content')
        <chat-app :user="{{auth()->user()}}"></chat-app>
@endsection
