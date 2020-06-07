@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/admin_style.css') }}">
@endpush

@section('title', 'Вход')

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="row mb-3 justify-content-center">
{{--                                <img class="embed-responsive col-8" src="/images/middle-logo.png" alt="logo">--}}
                            </div>
                            <h2>Вход <span class="text-secondary">или </span><a class="text-secondary" href="{{ route('admin.register') }}"><u>Регистрация</u></a></h2>
                            <h6 class="font-weight-light">Форма Входа для сотрудников и персонала</h6>
                            <form class="pt-3" method="POST" action="{{ route('admin.login') }}">
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
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           id="passwordInput" placeholder="Пароль" autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        ВХОД
                                    </button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            Запомнить меня
                                        </label>
                                    </div>
                                    <a href="{{ route('admin.password.request') }}" class="auth-link text-black">Забыли пароль?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
