@extends('layouts.lk')

@section('title', 'Альбомы')

@section('content')
    <div style="margin-left: auto;   margin-right: auto">
        <a class="btn btn-primary" href="{{route('anket.view',['id'=>$user->id])}}">Анкета</a>
        <div class="col-sm-6 col-12">
            @foreach($albums as $item)
                <a href="{{route('anket.albumItem',['id'=>$user->id,'albumid'=>$item->id])}}">
                    <img width="200" height="200" src="<?php echo asset($item->getCover())?>">
                    <div class="cell">
                        <div class="cell-overflow">
                            {{$item->name}},
                            {{$item->coutPhotos()}} фотографий
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection