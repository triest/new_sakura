@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/admin_style.css') }}">
@endpush

@section('title', 'Проверка электронной почты')

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-6 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="row mb-3 justify-content-center">
{{--                                <img class="embed-responsive col-6" src="/images/middle-logo.png" alt="logo">--}}
                            </div>
                            <h3 class="text-center">Проверка электронной почты</h3>
                            <p>Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.</p>

                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    На ваш адрес электронной почты была отправлена ​​новая ссылка для подтверждения.
                                </div>
                            @endif

                            <a href="{{ route('admin.verification.resend') }}">Если вы не получили письмо</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
