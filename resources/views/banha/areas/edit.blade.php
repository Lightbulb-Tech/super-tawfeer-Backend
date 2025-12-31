<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.title')}} {!! getFieldLanguage($locale) !!}</label>
                <input type="text" class="form-control" name="{{ $locale }}[title]"
                       data-validation="required"
                       value="{{$obj->translate($locale)->title}}">
            </div>
        @endforeach
        <div class="col-4 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.country')}} </label>
            <select class="form-control" name="country_id" data-validation="required">
                <option value="">{{__('banha.choose')}}</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}" @selected($country->id == $obj->country_id)>{{$country->title}}</option>
                @endforeach
            </select>
        </div>
            <div class="col-4 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.governorate')}}</label>
                <select class="form-control" name="governorate_id" data-validation="required">
                    <option value="">{{__('banha.choose')}}</option>
                    @foreach($governorates as $governorate)
                        <option value="{{$governorate->id}}"  @selected($governorate->id == $obj->governorate_id)>{{$governorate->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.shipping_price')}}</label>
                <input type="number" class="form-control" name="shipping_price" data-validation="required"
                       value="{{$obj->shipping_price}}">
            </div>
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
