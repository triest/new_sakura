@extends('layouts.app_admin')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/admin_style.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/admin_app.js') }}"></script>
@endpush

@section('body-class', 'sidebar-mini')

@section('content')
    <div class="container-scroller">
        @include('admin.includes.top_panel')

        <div class="container-fluid page-body-wrapper">
            @include('admin.includes.main_menu')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('inner')
                </div>
            </div>
        </div>
    </div>
@endsection
