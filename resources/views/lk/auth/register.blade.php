@extends('layouts.auth_lk')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/admin_style.css') }}">
@endpush

@section('title',  trans('auth.register2'))
@section('content')
    <script type="text/javascript" src="{{ asset('js/lk_login_register.js') }}"></script>
    <div class="container">
        <div class="block-login">
            <div class="block-login_container">
                <div class="name">@lang('auth.register')</div>
                <form class="form-lk" action="{{ route('lk.register') }}" method="post">
                    {{ csrf_field() }}
                    @if ($errors->has('email'))
                        <div class="error_p">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    @if ($errors->has('password'))
                        <div class="error_p">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                    <div class="group">
                        <label class="label_txt"><span></span>E-mail</label>
                        <div class="group_input">
                            <input type="text" class="input" id="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="group">
                                <label class="label_txt"><span></span>@lang('auth.enter_password')</label>
                                <div class="group_input">
                                    <input type="password" class="input" id="password" name="password"
                                           value="{{ old('password') }}" required>
                                    <div class="pt-button-eye">
                                        <div class="pt-button-eye-open" id="button-show-pasword" onclick="click_password()"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-12">
                            <div class="group">
                                <label class="label_txt"><span></span>@lang('auth.password_confirmation')</label>
                                <div class="group_input">
                                    <input type="password" class="input" id="password_confirmation"
                                           name="password_confirmation" value="{{ old('password_confirmation') }}"
                                           required>
                                    <div class="pt-button-eye">
                                        <div class="pt-button-eye-open" id="button-show-pasword-confirmation"  onclick="password_confirmation()"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="politics">
                        @lang('auth.access_rule_message')<a
                                href="#"> @lang('auth.rules')</a>
                    </p>

                    <button class="btn_auth">@lang('auth.register')</button>

                </form>

                <div class="txt_bot">@lang('auth.alredy_hame_account') <a
                            href="{{route("lk.login")}}">@lang('auth.enter')</a></div>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/lk_login_register.js') }}" defer></script>

@endsection

