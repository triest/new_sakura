@extends('layouts.lk', ['title'=> $user->name])

@section('title', $user->name)

@section('content')


    <div class="container" id="app">
        <div class="profile-form">

            <div class="form-lk_name"><b>{{$user->name}}</b>, {{$user->age}}
                @isset($user->city->name)
                    <small> ,{{$user->city->name}}</small>
                @endisset
            </div>
            <div class="">
            </div>

            <form class="form-lk" action="{{ route('lk.profile.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}


                <div class="group">


                    <div class="group-photo_upload">

                        <div class="group-upload_profile">
                            @if (Auth::check())
                                <anket-component :user="{{$user}}"></anket-component>
                            @else
                                <div class="alert alert-info">
                                    <a href="/lk/login"><b>Войдите</b></a> или <a href="/lk/register"><b>зарегистрируйтесь</b></a>
                                    что-бы отправить сообщение
                                </div>
                            @endif
                        </div>

                        <div class="photo_profile" id="photo_profile" data-remodal-target="upload_img">

                            <img src="{{asset( "$user->photo_profile_url")}}"
                                 alt="" id="profile_image" height="250px">

                        </div>

                    </div>
                </div>
                <div class="group">
                    <a href="{{route("anket.albums",['id'=>$user->id])}}" class="personal-area">Фотографии</a>
                </div>
                <div class="cell-online-overflow">
                <span class="online"></span>
                </div>
                <div class="row">
                    @if($user->target->isNotEmpty())
                        <div class="col-sm-6 col-12">
                            <div class="group">
                                <label class="label_txt"><span></span>Цель знакомства</label>
                                @foreach($user->target as $item)
                                    <p>
                                        {{$item->name}}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($user->interest->isNotEmpty())
                        <div class="col-sm-6 col-12">
                            <div class="group">
                                <label class="label_txt">Интересы</label>
                                @foreach($user->interest as $item)
                                    <p>
                                        {{$item->name}}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>


                @isset($user->relation->name)
                    <hr>
                    <p><label class="label_txt">Отношения: </label>
                        {{$user->relation->name}}
                    </p>
                @endisset
                    <hr>

                <div class="row">
                    <div class="col-sm-8 col-12">
                        <div class="group">
                            <label class="label_txt"><span></span>Обо мне</label>
                            <p>{{$user->description}}</p>

                        </div>
                    </div>
                </div>


            </form>

        </div>
        <a class="btn btn-primary" href="{{route("anket.main")}}">К списку анкет</a>
    </div>
<style>

    .online {
        height: 10px;
        width: 10px;
        background-color: #26ff26;
        border-radius: 50%;
        display: inline-block;

    }

</style>


@endsection
