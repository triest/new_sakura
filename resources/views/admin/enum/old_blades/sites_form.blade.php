@extends('layouts.admin')

@section('title', 'Настройки площадки')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Настройки площадки</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Площадки.</h6>
        </div>
        <div class="col-sm-8"></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @component('common.form', [
                        'edit' => isset($item->id),
                        'action' => isset($item->id) ? route('admin.enum.sites.update', $item->id) : route('admin.enum.sites.store'),
                    ])
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <h4>{{ $item->city }} - {{ $item->title }}</h4>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="active" value="active" @if ($item->status_write == 'active') checked @endif>
                                        Площадка активна
                                        <i class="input-helper"></i></label>
                                </div>
                                <div class="form-check mb-5">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="active" value="pause" @if ($item->status_write == 'pause') checked @endif>
                                        Работа площадки Приостановлена
                                        <i class="input-helper"></i></label>
                                </div>
                                @component('common.form.input_checkbox', ['name' => 'there_is_cafe', 'value' => old('there_is_cafe') ?? $item->there_is_cafe]) На площадке есть кафе @endcomponent
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
                        <a href="{{ route('admin.enum.sites.index') }}" class="btn btn-light">Отмена</a>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
