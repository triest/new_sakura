@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/admin_style.css') }}">
@endpush

@section('title', 'Восстановление пароля')

@section('content')
    <body class="sidebar-mini">
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="row mb-3 justify-content-center">
                                <img class="embed-responsive col-6" src="/images/middle-logo.png" alt="logo">
                            </div>
                            <h4>Восстановление пароля</h4>
                            <h6 class="font-weight-light">Введите ваш адрес электронной почты</h6>
                            <form class="pt-3" method="POST" action="{{ route('admin.password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           id="emailInput" placeholder="Адрес электронной почты" value="{{ old('email') }}" autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        Восстановить пароль
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
