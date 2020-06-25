@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', $event->name)
@section('content')

    <div class="container" id="app">
        <div class="profile-form">
            <b>Моё события</b>

            <div class="form-group">
                <div class="col-xs-11">
                    {{$event->name}}
                </div>
            </div>


            <div class="form-group">
                <div class="col-xs-17">
                    {{$event->description}}
                </div>
            </div>

            <div class="col-xs-11">
                @if(isset($city) && $city!=null)
                    {{$city->name}}
                    <br>
                @endif
                <label for="title">Место:</label>
                {{$event->place }}
            </div>
            <requwest-check :event="{{$event}}" :user="{{\Illuminate\Support\Facades\Auth::user()}}"></requwest-check>
            <div class="col-xs-11">
                <p>
                    Дата:{{$date_begin}}
                </p>
                Время:
                {{$time_begin}}
                <p>
                    Заявки принимаються до:
                    {{$date_applications }}
                </p>
                <p>
                    Время:
                    {{$time_applications}}
                </p>
            </div>
        </div>
    </div>

@endsection
