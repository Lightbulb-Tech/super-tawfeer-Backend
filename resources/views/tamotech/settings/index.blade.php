@extends('tamotech.layout.index')
@section('title')
    {{__('main.settings')}}
@endsection
@section('content')
    <div class="card p-4">
        <form
            action="{{isset($settings) ? $updateRoute : $storeRoute }}"
            method="post"
            enctype="multipart/form-data">
            @if(isset($settings))
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                @foreach (config('translatable.locales') as $locale)
                    <div class="col-6 mb-3">
                        <label for="nameBasic"
                               class="form-label">{{__('main.textSidebar')}} {!! getFieldLanguage($locale) !!}</label>
                        <textarea type="text" class="form-control" name="text_sidebar:{{$locale}}">
                            {{isset($settings) ? @$settings->translate($locale)->text_sidebar : ''}}
                        </textarea>

                    </div>
                @endforeach
                @foreach (config('translatable.locales') as $locale)
                    <div class="col-6 mb-3">
                        <label for="nameBasic"
                               class="form-label">{{__('main.textLogin')}} {!! getFieldLanguage($locale) !!}</label>
                        <textarea type="text" class="form-control" name="text_login:{{$locale}}" >
                            {{isset($settings) ? @$settings->translate($locale)->text_login : ''}}
                        </textarea>
                    </div>
                @endforeach
                @foreach (config('translatable.locales') as $locale)
                    <div class="col-6 mb-3">
                        <label for="nameBasic"
                               class="form-label">{{__('main.subTextLogin')}} {!! getFieldLanguage($locale) !!}</label>
                        <textarea type="text" class="form-control" name="subText_login:{{$locale}}">
                             {{isset($settings) ? @$settings->translate($locale)->text_login : ''}}
                        </textarea>
                    </div>
                @endforeach
                @foreach (config('translatable.locales') as $locale)
                    <div class="col-6 mb-3">
                        <label for="nameBasic"
                               class="form-label">{{__('main.footer_text')}} {!! getFieldLanguage($locale) !!}
                        </label>
                        <textarea type="text" class="form-control" name="footer_text:{{$locale}}">
                             {{isset($settings) ? @$settings->translate($locale)->text_login : ''}}
                        </textarea>
                    </div>
                @endforeach
                <div class="col-6 mb-3">
                    <label for="nameBasic" class="form-label">{{__('main.imageLogin')}}</label>
                    <input type="file" class="dropify" name="image_login"
                           data-default-file="{{ isset($settings) ? image_path($settings->image_login) : ''}}">
                </div>
                <div class="col-6 mb-3">
                    <label for="nameBasic" class="form-label">{{__('main.icon')}}</label>
                    <input type="file" class="dropify" name="icon"
                           data-default-file="{{ isset($settings) ? image_path($settings->icon) : ''}}">
                </div>
            </div>
            <br>
            @if(isset($settings))
                {!! updateButton($updateRoute) !!}
            @else
                {!! storeButton($storeRoute) !!}
            @endif
        </form>
    </div>
@endsection
@section('js')
    @include('tamotech.includes.dropfiy')
@endsection
