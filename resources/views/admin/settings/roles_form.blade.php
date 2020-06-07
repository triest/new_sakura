@extends('layouts.admin')

@section('title', 'Пользователи')

@section('inner')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <h4 class="card-title">Настрока роли пользователя</h4>

                        @component('common.form', [
                            'edit' => isset($item->id),
                            'action' => isset($item->id) ? route('admin.settings.roles.update', $item->id) : route('admin.settings.roles.store'),
                        ])
                            @component('common.form.input_text', ['name' => 'title', 'value' => old('title') ?? $item->title]) Наименование
                            @endcomponent
                            <h5 class="mb-3">Разрешения для данной роли</h5>
                            <div class="accordion" id="accordion" role="tablist">
                                @php $nn = 0 @endphp
                                @foreach($permissions as $group_name => $group_items)
                                    <div class="card">
                                        <div class="card-header" role="tab" id="heading-{{ ++$nn }}">
                                            <h6 class="mb-0">
                                                <a data-toggle="collapse" href="#collapse-{{ $nn }}" aria-expanded="false" aria-controls="collapse-{{ $nn }}">
                                                    {{ $group_name }}
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="collapse-{{ $nn }}" class="collapse" aria-labelledby="heading-{{ $nn }}" data-parent="#accordion">
                                            <div class="card-body">
                                                @foreach($group_items as $permission)
                                                    <div class="form-check form-check-flat form-check-primary mb-3">
                                                        <label class="form-check-label" for="permissions_{{ $permission->id }}Input">
                                                            <span class="font-weight-bold">{{ $permission->title }}</span> -
                                                            <span class="text-secondary">{{ $permission->route }}</span>
                                                            <input type="checkbox" name="permissions[{{ $permission->id }}]" class="form-check-input" id="permissions_{{ $permission->id }}Input"
                                                                   @if ($item->permissions->contains('id', $permission->id)) checked @endif>
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mr-2 mt-3">Сохранить</button>
                            <a href="{{ route('admin.settings.roles.index') }}" class="btn btn-light mt-3">Отмена</a>
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
