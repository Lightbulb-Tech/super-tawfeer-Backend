<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.title')}} {!! getFieldLanguage($locale) !!}</label>
                <input type="text" class="form-control" name="{{ $locale }}[title]">
            </div>
        @endforeach
        <div class="col-4 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.country')}}</label>
            <select class="form-control" name="country_id" data-validation="required">
                <option value="">{{__('banha.choose')}}</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.governorate')}}</label>
            <select class="form-control" name="governorate_id" data-validation="required">
                <option value="">{{__('banha.choose')}}</option>
                @foreach($governorates as $governorate)
                    <option value="{{$governorate->id}}">{{$governorate->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.shipping_price')}}</label>
            <input type="number" class="form-control" name="shipping_price" data-validation="required">
        </div>
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

