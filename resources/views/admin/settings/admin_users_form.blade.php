@extends('layouts.admin')

@section('title', 'Пользователи')

@section('inner')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <h4 class="card-title">Профиль пользователя</h4>
                        @component('common.form', [
                            'edit' => isset($user_admin->id),
                            'action' => isset($user_admin->id) ? route('admin.settings.admin_users.update', $user_admin->id) : route('admin.settings.admin_users.store'),
                        ])
                            <div class="row">
                                <div class="col-6">
                                    @component('common.form.input_text', ['name' => 'name', 'value' => old('name') ?? $user_admin->name])
                                        Имя @endcomponent
                                    @component('common.form.input_text', ['name' => 'surname', 'value' => old('surname') ?? $user_admin->surname])
                                        Фамилия @endcomponent
                                    @component('common.form.input_text', ['name' => 'email', 'value' => old('email') ?? $user_admin->email])
                                        Email @endcomponent
                                    @component('common.form.input_checkbox', ['name' => 'active', 'value' => old('active') ?? $user_admin->active])
                                        Активный @endcomponent

                                    <div class="form-group @error('role_id') has-danger @enderror">
                                        <label for="role_idInput">Роль пользователя</label>

                                        <select name="role_id"
                                                id="role_idInput"
                                                class="form-control @error('role_id') form-control-danger @enderror"
                                        >
                                            @foreach($roles as $role)
                                                @if($user_admin->role_id == $role->id)
                                                    <option value="{{$role->id}}" selected>{{$role->title}}</option>
                                                @else
                                                    <option value="{{$role->id}}">{{$role->title}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @error('role_id') <label id="role_id-error" class="error mt-2 text-danger" for="role_idInput">{{ $message }}</label> @enderror
                                    </div>
                                </div>

                                <div class="col-3">
                                    <h5 class="mb-3">Доступ к площадкам</h5>
                                    @forelse($sites as $site)
                                        <div class="form-check form-check-flat form-check-primary mb-3">
                                            <label class="form-check-label"
                                                   for="site_{{ $site->id }}Input">{{ $site->city }}
                                                - {{ $site->title }}
                                                <input type="checkbox" name="site[{{ $site->id }}]"
                                                       class="form-check-input" id="site_{{ $site->id }}Input"
                                                       @if ($user_admin->sites->contains('id', $site->id)) checked @endif>
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    @empty
                                        <p>Нет доступных площадок</p>
                                    @endforelse
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
                            <a href="{{ route('admin.settings.admin_users.index') }}" class="btn btn-light">Отмена</a>
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
