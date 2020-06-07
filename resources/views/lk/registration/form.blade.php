@extends('layouts.lk')

@push('scripts')
    <script src="{{ asset('js/inputmask/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('js/inputmask/inputmask.binding.js') }}"></script>
@endpush

@section('title', 'Онлайн регистрация')
@section('head_h1')
    <h1 class="text-center h1_title">Онлайн регистрация</h1>
@endsection

@section('inner')
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mt-4">
                <div class="card lk-card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('lk.registration.send') }}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="siteSelect">Выберите площадку:</label>
                                <select id="siteSelect" class="form-control @error('site') is-invalid @enderror" name="site" style="font-size: 1.2em">
                                    <option value="">-</option>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->id }}" @if( old('site') == $site->id ) selected @endif>{{ $site->city }} - {{ $site->title }}</option>
                                    @endforeach
                                </select>
                                @error('site')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="dateInput">В какой день Вы собираетесь нас посетить: </label>
                                <input type="date" name="date" class="form-control form-control-lg @error('date') is-invalid @enderror"
                                       id="dateInput" value="{{ old('date') ?? $item->visit }}" autofocus>
                                @error('date')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <h4>Данные сопровождающего:</h4>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for=lastNameInput">Фамилия:</label>
                                        <input type="text" name="last_name" class="form-control form-control-lg @error('last_name') is-invalid @enderror"
                                               id="lastNameInput" value="{{ old('last_name') ?? $item->last_name }}">
                                        @error('last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="firstNameInput">Имя:</label>
                                        <input type="text" name="first_name" class="form-control form-control-lg @error('first_name') is-invalid @enderror"
                                               id="firstNameInput" value="{{ old('first_name') ?? $item->first_name }}">
                                        @error('first_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="phoneInput">Номер телефона:</label>
                                        <input type="text" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                               id="phoneInput" placeholder="+7 (___) ___-__-__" value="{{ old('phone') ?? $item->phone }}"
                                               data-inputmask-alias="+7 (999) 999-99-99">
                                        @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                            <h4>Добавить детей:</h4>
                            @error('children_not_exist')<div class="text-danger" style="font-size: 80%;" role="alert"><strong>{{ $message }}</strong></div>@enderror
                            <div class="list-wrapper mb-4">
                                <ul class="d-flex flex-column-reverse">
                                    @foreach ($childrens as $children)
                                        <li class="row">
                                            <div class="col-auto">
                                                <div class="form-check">
                                                    <label class="form-check-label text-muted font-weight-medium">
                                                        <input class="checkbox" type="checkbox" name="my_children[]" value="{{ $children->id }}" @if (in_array($children->id, old('my_children') ?? [])) checked @endif>
                                                        <i class="input-helper"></i><i class="input-helper"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col">{{ $children->first_name }}</div>
                                            <div class="col">{{ $children->birthday->format('d.m.Y г.') }}</div>
                                            <div class="col">{{ $children->card_number }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <h4>Добавить гостей (детей):</h4>
                            @error('children_not_exist')<div class="text-danger mb-4" style="font-size: 80%;" role="alert"><strong>{{ $message }}</strong></div>@enderror
                            <div id="childrenContainer">
                                @if(old('name'))
                                    @foreach (old('name') as $key => $value)
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="childNameInput">Имя: </label>
                                                    <input type="text" name="name[{{ $key }}]" class="form-control form-control-lg @error('name.' . $key) is-invalid @enderror"
                                                           id="childNameInput" value="{{ old('name')[$key] }}">
                                                    @error('name.' . $key)<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="childBirthdayInput">День рождения:</label>
                                                    <input type="date" name="birthday[{{ $key }}]" class="form-control form-control-lg @error('birthday.' . $key) is-invalid @enderror"
                                                           id="childBirthdayInput" value="{{ old('birthday')[$key] }}">
                                                    @error('birthday.' . $key)<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-auto align-self-center delete-button">
                                                <a href="#" class="btn btn-danger" onclick="childRemove(this); return false;"><i class="mdi mdi-trash-can"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="text-center">
                                <a id="addChildrenButton" class="btn btn-secondary btn-lg" href="#add_children">Добавить ребенка</a>
                            </div>
                            <div class="text-center mt-4">
                                <button class="btn btn-primary btn-lg">Отправить</button>
                            </div>
                        </form>
                        <div id="childrenPrototype" class="row" style="display: none">
                            <div class="col">
                                <div class="form-group">
                                    <label for="childNameInput">Имя: </label>
                                    <input type="text" name="name[]" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           id="childNameInput" value="">
                                    @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="childBirthdayInput">День рождения:</label>
                                    <input type="date" name="birthday[]" class="form-control form-control-lg @error('birthday') is-invalid @enderror"
                                           id="childBirthdayInput" value="">
                                    @error('birthday')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="col-auto align-self-center delete-button">
                                <a href="#" class="btn btn-danger"><i class="mdi mdi-trash-can"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>

        function childRemove(el) {
            console.log(el);
            $(el).closest('.row').slideUp(function () {
                $(this).remove()
            });
        }

        $(function () {

            let childrenContainer = $('#childrenContainer');
            let addChildren = $('#addChildrenButton');

            addChildren.click(function () {

                let newChildren = $('#childrenPrototype').clone();
                newChildren.find('input').val('');
                newChildren.find('.delete-button a').click(function () {
                    childRemove(this);
                    return false;
                });
                newChildren.appendTo(childrenContainer);
                newChildren.slideDown();
                return false;
            });
        });

        // Для расскрытия всех дампов
        let compacted = document.querySelectorAll('.sf-dump-compact');
        for (let i = 0; i < compacted.length; i++) compacted[i].className = 'sf-dump-expanded';

    </script>
@endpush
