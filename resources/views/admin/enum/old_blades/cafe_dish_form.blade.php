@extends('layouts.admin')

@section('title', 'Блюдо')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Блюдо</h3>
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
                        'action' => isset($item->id) ? route('admin.enum.cafe.dish_update', $item->id) : route('admin.enum.cafe.dish_store', $group),
                        'media' => true
                    ])
                        <div class="row">
                            <div class="col-lg-6">
                                @component('common.form.input_text', ['name' => 'title', 'value' => old('title') ?? $item->title]) Наименование @endcomponent
                                @component('common.form.input_ckeditor', ['name' => 'description', 'value' => old('description') ?? $item->description]) Описание @endcomponent
                                <h5>Фотографии блюда:</h5>
                                <div class="row">
                                    @forelse($item->getMedia('gallery') as $media)
                                        <div
                                                class="col-4 tiles mr-3 mb-3 text-center @if($media->id == $item->cover_media_id) bg-primary @endif">
                                            <img class="img-fluid" src="{{ $media->getUrl('thumb') }}">
                                            <div class="btn-group">
                                                <a class="btn btn-primary btn-sm button-media-cover"
                                                   title="На главную" href="#"
                                                   data-url="{{ route('admin.enum.cafe.media_cover', [$item->id, $media->id]) }}">
                                                    <i class="mdi mdi-shield-check menu-icon"></i>
                                                </a>
                                                <a class="btn btn-warning btn-sm button-media-delete"
                                                   title="Удалить" href="#"
                                                   data-url="{{ route('admin.enum.cafe.media_delete', [$item->id, $media->id]) }}">
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
                                        @component('common.form.input_gallery', ['name' => 'gallery', 'gallery' => '']) Добавить Фотографию блюда @endcomponent
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" name="action" value="save"
                                                class="btn btn-primary mr-2">Загрузить
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h5 class="mb-3">Блюдо на площадках</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover center-aligned-table">
                                        <thead>
                                        <tr>
                                            <th>Площадка</th>
                                            <th>Активность</th>
                                            <th>Цена</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sites as $site)
                                            <tr>
                                                <td>
                                                    {{ $site->title }}
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-flat form-check-primary mb-0 mt-0">
                                                        <label class="form-check-label" for="site_{{ $site->id }}Input">
                                                            Активно
                                                            <input type="checkbox" name="active[{{ $site->id }}]"
                                                                   class="form-check-input" id="site_{{ $site->id }}Input"
                                                                   @if ($item->sites->contains('id', $site->id)) checked @endif>
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control p-1" name="price[{{ $site->id }}]" placeholder="Цена"
                                                           value="{{ $item->sites->find($site->id)->pivot->price ?? '' }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2" name="action" value="save_and_back">Сохранить</button>
                        <a href="{{ route('admin.enum.cafe.index', $group) }}" class="btn btn-light">Отмена</a>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.enum._gallery_js')
