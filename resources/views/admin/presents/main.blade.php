@extends('layouts.admin')

@section('title', 'Управление подарками')

@section('content')
    <div class="container" id="app">
        <div class="profile-form">
            <presents-admin-list></presents-admin-list>
        </div>
    </div>
@endsection