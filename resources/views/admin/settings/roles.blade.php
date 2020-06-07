@extends('layouts.admin')

@section('title', 'Пользователи')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Роли пользователей системы</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Роль пользователя определяет его возможности в системе</h6>
        </div>
        <div class="col-sm-8">
            <div class="d-flex align-items-center justify-content-md-end">
                <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
                    <p class="text-muted">Всего</p>
                    <h6 class="font-weight-medium text-dark mb-0">{{ $roles->total() }}</h6>
                </div>
                @can('access', 'admin.settings.roles.create')
                    <div class="mb-xl-0 ml-4">
                        <a class="btn btn-primary" href="{{ route('admin.settings.roles.create') }}">Создать новую
                            роль</a>
                    </div>
                @endcan
                <div class="mb-xl-0 ml-4">
                    {{ $roles->links() }}
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
                                <th>Наименование</th>
{{--                                <th>Разрешения</th>--}}
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>
                                        @can('access', 'admin.settings.roles.edit')
                                            <a class="text-dark font-weight-bold"
                                               href="{{ route('admin.settings.roles.edit', $role->id) }}">
                                                {{ $role->title }}
                                            </a>
                                        @else
                                            {{ $role->title }}
                                        @endcan
                                    </td>
{{--                                    <td>{{ $role->permissions->pluck('title')->join(', ') }}</td>--}}
                                    <td>
                                        @can('access', 'admin.settings.roles.edit')
                                            <a href="{{ route('admin.settings.roles.edit', $role->id) }}"
                                               class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                                        @endcan
                                        @can('access', 'admin.settings.roles.destroy')
                                            <a href="{{ route('admin.settings.roles.destroy', $role->id) }}"
                                               data-id="{{ $role->id }}" class="mr-1 text-muted p-2 button-destroy"><i
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
