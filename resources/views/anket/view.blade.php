@extends('layouts.lk')

@section('title', $user->name)

@section('content')


    <div class="container" id="app">
        <div class="profile-form">

            <div class="form-lk_name"><b>{{$user->name}}</b>, {{$user->age}}
                <small> ,{{$user->getCity()->name}}</small>
            </div>
            <div class="">
            </div>

            <form class="form-lk" action="{{ route('lk.profileStore') }}" method="post" enctype="multipart/form-data">
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
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="group">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <anket-component2 :user="{{$user}}" :gifts="{{$gifts}}"></anket-component2>
                    </div>
                </div>
                <div class="group">
                    <a href="{{route("anket.albums",['id'=>$user->id])}}" class="personal-area">Фотографии</a>
                </div>
                <div class="row">
                    @if($targets->isNotEmpty())
                        <div class="col-sm-6 col-12">
                            <div class="group">
                                <label class="label_txt"><span></span>Цель знакомства</label>
                                @foreach($targets as $item)
                                    <p>
                                        {{$item->name}}

                                    </p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($interests->isNotEmpty())
                        <div class="col-sm-6 col-12">
                            <div class="group">
                                <label class="label_txt">Интересы</label>
                                @foreach($interests as $item)
                                    <p>
                                        {{$item->name}}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>


                @isset($user->relation()->first()->name)
                    <hr>
                    <p><label class="label_txt">Отношения: </label>
                        {{$user->relation()->first()->name}}
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




@endsection
