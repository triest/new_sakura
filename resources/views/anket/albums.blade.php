@extends('layouts.lk')

@section('title', 'Альбомы')

@section('content')
    <div style="margin-left: auto;   margin-right: auto">
        <div class="col-sm-6 col-12">
            @foreach($albums as $item)
                <a href="{{route('anket.albumItem',['id'=>$user->id,'albumid'=>$item->id])}}">
                    <img width="200" height="200" src="<?php echo asset("/images/albums/" . $item->getCover())?>">
                    <div class="cell">
                        <div class="cell-overflow">
                            {{$item->name}},
                            {{$item->coutPhotos()}} фототографий
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection