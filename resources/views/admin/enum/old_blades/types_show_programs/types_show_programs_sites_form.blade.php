@extends('layouts.admin')

@section('title', 'Тип шоу программ на площадке')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Тип шоу програмы на площадке</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Тип шоу программ.</h6>
        </div>
        <div class="col-sm-8"></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @component('common.form', [
                        'edit' => true,
                        'action' => route('admin.enum.types_show_programs_sites.update', $item->id),
                    ])
                        <row class="row">
                            <div class="col-6">
                                <h4>Площадка: {{ $item->site->title }}</h4>
                                <h5>Тип шоу програмы: {{ $item->type_show_program->title }}</h5>
                            </div>
                        </row>
                        <div class="row">
                            <div class="col-lg-8">
                                @component('common.form.input_text', ['name' => 'price', 'value' => old('price') ?? $item->price])
                                    Цена
                                @endcomponent

                                @component('common.form.input_checkbox', ['name' => 'active', 'value' => old('active') ?? $item->active])
                                    Активный
                                @endcomponent
                            </div>
                        </div>
                        <button type="submit" name="action" value="save_and_back" class="btn btn-primary mr-2">
                            Сохранить и вернуться к списку
                        </button>
                        <button type="submit" name="action" value="save" class="btn btn-primary mr-2">Сохранить
                        </button>
                        <a href="{{ route('admin.enum.types_show_programs_sites.index', $item->sites_id) }}"
                           class="btn btn-light">Вернуться к списку</a>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection

