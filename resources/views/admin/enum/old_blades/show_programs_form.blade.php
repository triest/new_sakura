@extends('layouts.admin')

@section('title', 'Шоу-программа')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Шоу-программа</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Шоу-программы.</h6>
        </div>
        <div class="col-sm-8"></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @component('common.form', [
                        'edit' => isset($item->id),
                        'action' => isset($item->id) ? route('admin.enum.show_programs.update', $item->id) : route('admin.enum.show_programs.store'),
                    ])
                        <div class="row">
                            <div class="col-lg-8">
                                @component('common.form.input_text', ['name' => 'title', 'value' => old('title') ?? $item->title]) Наименование @endcomponent
                                @component('common.form.input_checkbox', ['name' => 'active', 'value' => old('active') ?? $item->active]) Активна @endcomponent
                                @component('common.form.input_ckeditor', ['name' => 'description', 'value' => old('description') ?? $item->description]) Описание @endcomponent
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
                        <a href="{{ route('admin.enum.show_programs.index') }}" class="btn btn-light">Отмена</a>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
