@extends('tamotech.layout.index')
@section('title')
    {{__('main.file_manager')}}
@endsection
@section("style")
    {{-- <link rel="stylesheet" href="{{asset("admin")}}/assets/cssbundle/summernote.min.css"/> --}}
    <style>
        .tox-notification,
        .tox .tox-statusbar {
            display: none !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
@endsection
@section('content')
    <div id="fm" style="height: 100%;"></div>
@endsection
@section('js')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection
