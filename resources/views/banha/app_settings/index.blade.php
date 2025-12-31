@extends('tamotech.layout.index')
@section('title')
    {{__('banha.app_settings')}}
@endsection
@section('content')
    <div class="card p-4">
        <form id="form"
              action="{{isset($appSetting) ? $updateRoute : $storeRoute }}"
              method="post"
              enctype="multipart/form-data">
            @if(isset($appSetting))
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                @foreach (config('translatable.locales') as $locale)
                    <div class="col-6 mb-3">
                        <label for="nameBasic"
                               class="form-label">{{__('banha.app_name')}} {!! getFieldLanguage($locale) !!}</label>
                        <input type="text" class="form-control" name="{{ $locale }}[app_name]"
                               value="{{isset($appSetting) ? @$appSetting->translate($locale)->app_name : ''}}">

                    </div>
                @endforeach
                @foreach (config('translatable.locales') as $locale)
                    <div class="col-6 mb-3">
                        <label for="nameBasic"
                               class="form-label">{{__('banha.address')}} {!! getFieldLanguage($locale) !!}</label>
                        <input type="text" class="form-control" name="{{ $locale }}[address]"
                               value="{{isset($appSetting) ? @$appSetting->translate($locale)->address : ''}}">

                    </div>
                @endforeach
                <div class="col-6 mb-3">
                    <label for="nameBasic" class="form-label">{{__('banha.email')}}</label>
                    <input type="email" class="form-control" name="email"
                           value="{{isset($appSetting) ? @$appSetting->email : ''}}">
                </div>
                <div class="col-6 mb-3">
                    <label for="nameBasic" class="form-label">{{__('banha.phone')}}</label>
                    <input type="number" class="form-control" name="phone"
                           value="{{isset($appSetting) ? @$appSetting->phone : ''}}">
                </div>
                <div class="col-4 mb-3">
                    <label for="nameBasic" class="form-label">{{__('banha.app_commission')}}</label>
                    <input type="number" class="form-control" name="app_commission" min="0.0" step="0.1"
                           value="{{isset($appSetting) ? @$appSetting->app_commission : ''}}">
                </div>
                <div class="col-4 mb-3">
                    <label for="nameBasic" class="form-label">{{__('banha.point_price')}}</label>
                    <input type="number" class="form-control" name="point_price" min="0.1" step="0.1"
                           value="{{isset($appSetting) ? @$appSetting->point_price : ''}}">
                </div>
                <div class="col-4 mb-3">
                    <label for="daysBasic" class="form-label">{{ __('banha.days_that_shipping_is_free') }}</label>
                    <select class="form-control select2" name="days[]" data-validation="required" multiple>
                        <option value="">{{ __('banha.choose') }}</option>
                        <option value="Saturday" {{isset($appSetting) && $appSetting->days != null && in_array('Saturday',$appSetting->days) ? 'selected' : ''}}>{{ __('banha.saturday') }}</option>
                        <option value="Sunday" {{isset($appSetting) && $appSetting->days != null && in_array('Sunday',$appSetting->days) ? 'selected': ''}}>{{ __('banha.sunday') }}</option>
                        <option value="Monday" {{isset($appSetting) && $appSetting->days != null && in_array('Monday',$appSetting->days) ? 'selected': ''}}>{{ __('banha.monday') }}</option>
                        <option value="Tuesday" {{isset($appSetting) && $appSetting->days != null && in_array('Tuesday',$appSetting->days) ? 'selected': ''}}>{{ __('banha.tuesday') }}</option>
                        <option value="Wednesday" {{isset($appSetting) && $appSetting->days != null && in_array('Wednesday',$appSetting->days) ? 'selected': ''}}>{{ __('banha.wednesday') }}</option>
                        <option value="Thursday" {{isset($appSetting) && $appSetting->days != null && in_array('Thursday',$appSetting->days) ? 'selected': ''}}>{{ __('banha.thursday') }}</option>
                        <option value="Friday" {{isset($appSetting) && $appSetting->days != null  && in_array('Friday',$appSetting->days)? 'selected' : ''}}>{{ __('banha.friday') }}</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="nameBasic" class="form-label">{{__('banha.logo')}}</label>
                    <input type="file" class="dropify" name="logo"
                           data-default-file="{{ isset($appSetting) ? image_path($appSetting->logo) : ''}}">
                </div>
            </div>
            <br>
            @if(isset($appSetting))
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
