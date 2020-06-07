@extends('layouts.admin')

@section('title', 'Комната')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Комната</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Комнаты.</h6>
        </div>
        <div class="col-sm-8"></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @component('common.form', [
                        'edit' => isset($item->id),
                        'action' => isset($item->id) ? route('admin.enum.rooms.update', $item->id) : route('admin.enum.rooms.store', $site),
                        'media' => true
                    ])
                        <div class="row">
                            <div class="col-lg-8">
                                @component('common.form.input_text', ['name' => 'title', 'value' => old('title') ?? $item->title]) Наименование @endcomponent
                                @component('common.form.input_text', ['name' => 'capacity', 'value' => old('capacity') ?? $item->capacity]) Вместимость (чел.) @endcomponent
                                @component('common.form.input_text', ['name' => 'area', 'value' => old('area') ?? $item->area]) Площадь (м2) @endcomponent
                                @component('common.form.input_ckeditor', ['name' => 'description', 'value' => old('description') ?? $item->description]) Описание @endcomponent
                            </div>
                        </div>
                        <h5>Фотографии комнаты:</h5>
                        <div class="row">
                            @forelse($item->getMedia('gallery') as $media)
                                <div class="col-2 tiles mr-3 mb-3 text-center @if($media->id == $item->cover_media_id) bg-primary @endif">
                                    <img class="img-fluid" src="{{ $media->getUrl('thumb') }}"><br>
                                    <div class="btn-group">
                                        <a class="btn btn-primary btn-sm button-media-cover"
                                           title="На главную" href="#"
                                           data-url="{{ route('admin.enum.rooms.media_cover', [$item->id, $media->id]) }}">
                                            <i class="mdi mdi-shield-check menu-icon"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm button-media-delete"
                                           title="Удалить" href="#"
                                           data-url="{{ route('admin.enum.rooms.media_delete', [$item->id, $media->id]) }}">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col"><p>Фотографии не загружены</p></div>
                            @endforelse
                        </div>
                        <div class="row align-items-center">
                            <div class="col-8">
                                @component('common.form.input_gallery', ['name' => 'gallery', 'gallery' => ''])
                                    Добавить Фотографию комнаты @endcomponent
                            </div>
                            <div class="col-4">
                                <button type="submit" name="action" value="save"
                                        class="btn btn-primary mr-2">Загрузить
                                </button>
                            </div>
                        </div>
                        <button type="submit" name="action" value="save_and_back" class="btn btn-primary mr-2">
                            Сохранить и вернуться к списку
                        </button>
                        <button type="submit" name="action" value="save" class="btn btn-primary mr-2">Сохранить
                        </button>
                        <a href="{{ route('admin.enum.rooms.index', $item->sites_id) }}"
                           class="btn btn-light">Вернуться к списку</a>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.enum._gallery_js')
