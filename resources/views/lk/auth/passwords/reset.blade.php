@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/admin_style.css') }}">
@endpush

@section('title', 'Сброс пароля')

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 login-half-bg d-flex flex-row">
                        <p class="text-white font-weight-medium text-center flex-grow align-self-end">{{ config('app.name') }} {{ date('Y') }}</p>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">
                            <h1>Сбросить пароль</h1>
                            <form class="pt-3" method="POST" action="{{ route('lk.password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label for="emailInput">Ваш email</label>
                                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           id="emailInput" placeholder="Email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="passwordInput">Новый пароль</label>
                                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           id="passwordInput" placeholder="Пароль" autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="passwordConfirmInput">Повторите пароль</label>
                                    <input type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                           id="passwordConfirmInput" name="password_confirmation" placeholder="Пароль" autocomplete="new-password">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        Сохранить пароль
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
