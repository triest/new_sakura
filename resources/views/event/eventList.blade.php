@extends('layouts.lk', ['title' => 'Мои события'])
@section('title', 'Мои события')
@section('content')

    <div class="container" id="app">
        <a class="btn btn-primary" href="{{route('event.create')}}">Создать событие</a>
        @if(count($events))
        <input class="form-control" id="myInput" type="text" placeholder="Найти">

        <div class="profile-form">
            <table class="table">
                <tbody  id="myTable">
                @foreach($events as $event)
                    <tr>
                        <td><a href="{{route('event.show',['event'=>$event->id])}}">{{$event->name}}</a></td>
                        <td>{{$event->place}}</td>
                        <td>{{$event->begin}}</td>
                        <td>@isset($event->status->name){{$event->status->name}}@endisset</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            <script>
                $(document).ready(function(){
                    $("#myInput").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#myTable tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            </script>
        @else
            Событий нет. Можно его создать!
            <a class="btn btn-primary" href="{{route('event.create')}}">Создать событие</a>
        @endif
    </div>
@endsection
