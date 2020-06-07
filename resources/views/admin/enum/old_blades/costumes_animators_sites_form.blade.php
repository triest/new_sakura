@extends('layouts.admin')

@section('title', 'Свойства костюма на площадке')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Костюм аниматора на площадке</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Костюмы аниматоров на площадке.</h6>
        </div>
        <div class="col-sm-8"></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @component('common.form', [
                        'edit' => true,
                        'action' => route('admin.enum.costumes_animators_sites.update', $item->id),
                        'media' => true
                    ])
                        <row class="row">
                            <div class="col-6">
                                <h4>Площадка: {{ $item->site->title }}</h4>
                                <h5>Костюм: {{ $item->costume->title }}</h5>
                            </div>
                        </row>
                        <div class="row">
                            <div class="col-lg-8">
                                @component('common.form.input_text', ['name' => 'count', 'value' => old('count') ?? $item->count])
                                    Количество @endcomponent
{{--                                @component('common.form.input_text', ['name' => 'price', 'value' => old('price') ?? $item->price])--}}
{{--                                    Цена @endcomponent--}}
                                @component('common.form.input_ckeditor', ['name' => 'description', 'value' => old('description') ?? $item->description])
                                    Описание
                                @endcomponent
                                <h5>Фотографии костюма:</h5>
                                <div class="row">
                                    @forelse($item->getMedia('gallery') as $media)
                                        <div
                                                class="col-4 tiles mr-3 mb-3 text-center @if($media->id == $item->cover_media_id) bg-primary @endif">
                                            <img class="img-fluid" src="{{ $media->getUrl('thumb') }}">
                                            <div class="btn-group">
                                                <a class="btn btn-primary btn-sm button-media-cover"
                                                   title="На главную" href="#"
                                                   data-url="{{ route('admin.enum.costumes_animators_sites.media_cover', [$item->id, $media->id]) }}">
                                                    <i class="mdi mdi-shield-check menu-icon"></i>
                                                </a>
                                                <a class="btn btn-warning btn-sm button-media-delete"
                                                   title="Удалить" href="#"
                                                   data-url="{{ route('admin.enum.costumes_animators_sites.media_delete', [$item->id, $media->id]) }}">
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
                                            Добавить Фотографию костюма @endcomponent
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" name="action" value="save"
                                                class="btn btn-primary mr-2">Загрузить
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <button type="submit" name="action" value="save_and_back" class="btn btn-primary mr-2">
                            Сохранить и вернуться к списку
                        </button>
                        <button type="submit" name="action" value="save" class="btn btn-primary mr-2">Сохранить
                        </button>
                        <a href="{{ route('admin.enum.costumes_animators_sites.index', $item->sites_id) }}"
                           class="btn btn-light">Вернуться к списку</a>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.enum._gallery_js')
