@extends('layouts.admin')

@section('title', 'Категория блюд')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Категория блюд</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Кафе.</h6>
        </div>
        <div class="col-sm-8"></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @component('common.form', [
                        'edit' => isset($item->id),
                        'action' => isset($item->id) ? route('admin.enum.cafe.group_update', $item->id) : route('admin.enum.cafe.group_store'),
                        'media' => true
                    ])
                        <div class="row">
                            <div class="col-lg-8">
                                @component('common.form.input_text', ['name' => 'title', 'value' => old('title') ?? $item->title]) Наименование @endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                @if ($item->getMedia('avatar'))
                                    <img style="max-height: 150px" src="{{ $item->getFirstMediaUrl('cover') }}" alt="">
                                @endif
                                @component('common.form.input_gallery', ['name' => 'cover', 'cover' => '']) Добавить Фотографию для категории @endcomponent
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
                        <a href="{{ route('admin.enum.cafe.index', $item->id) }}" class="btn btn-light">Отмена</a>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
