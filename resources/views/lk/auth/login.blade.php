@extends('layouts.auth_lk')

{{--@push('styles')--}}
{{--    <link rel="stylesheet" href="{{ mix('css/admin_style.css') }}">--}}
{{--@endpush--}}

@section('title',  trans('auth.enter'))
@section('content')
    <div class="block-login">
        <div class="block-login_container">

            <div class="name">Войти</div>
            <form class="form-lk" action="{{ route('lk.login') }}" method="post">
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
                    <label class="label_txt">E-mail</label>
                    <div class="group_input">
                        <input type="text" class="input" id="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>


                <div class="group">
                    <label class="label_txt">@lang('password')</label>
                    <div class="group_input @if(strlen(old('password')) > 8) accepted @endif">
                        <input type="password"
                               id="password"
                               name="password"
                               class="input"
                               value="{{ old('password') }}"
                               data-type="password"
                        >
                        <div class="pt-button-eye">
                            <div class="pt-button-eye-close"></div>
                        </div>
                    </div>
                </div>
                <script>
                    $$(() => {
	                    $("input[name='password']").on('input', function() {
	                    	let parent = $(this).parent();

                            if($(this).val().length >= 8) {
                            	if(! $(parent).hasClass('accepted')) {
                            		$(parent).addClass('accepted')
                                }
                            } else {
	                            if($(parent).hasClass('accepted')) {
		                            $(parent).removeClass('accepted')
	                            }
                            }
                        })

                        $(".pt-button-eye")
                        .on('click', e => {
                            e.preventDefault();
                            let el = $("input[name='password']")

                            if(el.attr('data-type') == 'password') {
	                            el.attr('type', 'text')
                                .attr('data-type', 'text');
                            } else {
	                            el.attr('type', 'password');
                                $(document).off(".button_eye");
	                            el.attr('data-type', 'password');
                            }
                        });

                        // $("input").on('input', function() {
                        //     $("ul.list_error[data-for='" + $(this).attr('name') + "']").removeClass('filled').html('');
                        // });

                    });
                </script>


                <p class="forgot_password"><a href="#">Забыли пароль?</a></p>

                <div class="group">
                    <input class="radio" id="radio-1" type="radio" name="radio">
                    <label for="radio-1"><span>Запомнить меня</span></label>
                </div>

                <button class="btn_auth">Войти</button>

            </form>

            <div class="form-lk_txt-bot"> <a
                        href="{{route("lk.register")}}">Зарегистрироваться</a>
            </div>

        </div>
    </div>
@endsection
