@extends('layouts.admin')

@section('title', 'Пользователи')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Пользователи системы</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Внутренние пользователи системы: администраторы, сотрудники, ...</h6>
        </div>
        <div class="col-sm-8">
            <div class="d-flex align-items-center justify-content-md-end">
                <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
                    <p class="text-muted">Всего</p>
                    <h6 class="font-weight-medium text-dark mb-0">{{ $admins->total() }}</h6>
                </div>
                <div class="mb-xl-0">
                    <form class="form-inline float-left" action="{{ route('admin.settings.admin_users.index') }}">
                        <div class="input-group">
                            <label class="col-sm-3 col-form-label" for="">Поиск: </label>
                            <input type="text" name="query" class="form-control" placeholder="Имя или Фамилия" value="{{ $query ?? '' }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-primary" type="button">Найти</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mb-xl-0 ml-4">
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover center-aligned-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Роль</th>
                                <th>Площадки</th>
                                <th>Активный</th>
                                <th>Добавлен</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td>
                                        @can('access', 'admin.settings.admin_users.edit')
                                            <a class="text-dark font-weight-bold" href="{{ route('admin.settings.admin_users.edit', $admin->id) }}">
                                                {{ $admin->name }} {{ $admin->surname }}
                                            </a>
                                        @else
                                            {{ $admin->name }} {{ $admin->surname }}
                                        @endcan
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
{{--                                        @foreach($admin->roles as $role)--}}
{{--                                            <div class="badge badge-pill badge-outline-info">--}}
{{--                                                @can('access', 'admin.settings.roles.edit')--}}
{{--                                                    <a class=" " href="{{ route('admin.settings.roles.edit', $role->id) }}">{{ $role->title }}</a>--}}
{{--                                                @else--}}
{{--                                                    {{ $role->title }}--}}
{{--                                                @endcan--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
                                        @if($admin->roles)
                                            {{ $admin->roles->title }}
                                        @else
                                            не установлена
                                        @endif
                                    </td>
                                    <td>
                                        @if ($admin->sites->count() > 2)
                                            <div class="badge badge-pill badge-outline-success">
                                                ... {{ $admin->sites->count() }} ...
                                            </div>
                                        @else
                                            @foreach($admin->sites as $site)
                                                <div class="badge badge-pill badge-outline-success">
                                                    {{ $site->title }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if ($admin->active)
                                            <label class="badge badge-success">Активен</label>
                                        @else
                                            <label class="badge badge-warning">Неактивен</label>
                                        @endif
                                    </td>
                                    <td>{{ $admin->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @can('access', 'admin.settings.admin_users.edit')
                                            <a href="{{ route('admin.settings.admin_users.edit', $admin->id) }}" class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                                        @endcan
                                        @can('access', 'admin.settings.admin_users.destroy')
                                            <a href="{{ route('admin.settings.admin_users.destroy', $admin->id) }}" data-id="{{ $admin->id }}" class="mr-1 text-muted p-2 button-destroy"><i
                                                        class="mdi mdi-delete"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
