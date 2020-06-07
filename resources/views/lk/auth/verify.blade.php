@extends('layouts.auth_lk')

@section('title', 'Проверка электронной почты')

@section('content')

    <div class="container">

        <div class="message_block">
            <div class="name">
                Проверка электронной почты
            </div>
            <div class="txt">

                Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.

{{--                @if (session('resent'))--}}
{{--                    <div class="alert alert-success" role="alert">--}}
{{--                        На ваш адрес электронной почты была отправлена ​​новая ссылка для подтверждения.--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                <div class="row mt-3">--}}
{{--                    <div class="col-lg-6">--}}
{{--

{{--                    </div>--}}

{{--                    <div class="col-lg-6 text-right">--}}
{{--                        @auth--}}
{{--                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Авторизация</a>--}}
{{--                            <form id="logout-form" action="{{ route('lk.logout') }}" method="POST" style="display: none;">@csrf</form>--}}
{{--                        @endauth--}}
{{--                    </div>--}}
{{--                </div>--}}

                <br>
                <a href="#" onclick="event.preventDefault(); document.getElementById('resend-form').submit();">Если вы не получили письмо</a>
                <form id="resend-form" action="{{ route('lk.verification.resend') }}" method="POST" style="display: none;">@csrf</form>
                <br>
                @auth
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Авторизация</a>
                    <form id="logout-form" action="{{ route('lk.logout') }}" method="POST" style="display: none;">@csrf</form>
                @endauth

            </div>
        </div>
    </div>
@endsection
