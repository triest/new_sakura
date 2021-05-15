@extends('layouts.lk')

@section('title', 'Подарки')

@section('content')
    <div class="row">
        @foreach($giftActs as $giftAct)
            <div class="col-md-4">

                <div class="card mb-4 box-shadow">
                    <img src="{{asset( $giftAct->gift->image_url)}}" title="{{$giftAct->gift->name}}"
                         height="250px" width="250px">

                    <div class="card-body">
                        {{$giftAct->created}}

                        От <a href="{{route('anket.view',['id'=>$giftAct->who->id])}}"> {{$giftAct->who->name}} </a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
