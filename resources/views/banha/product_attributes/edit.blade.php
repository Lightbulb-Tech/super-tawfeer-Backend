<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.attribute_name')}} {!! getFieldLanguage($locale) !!}</label>
                <input type="text" class="form-control" name="{{ $locale }}[attribute_name]" data-validation="required"
                       value="{{$obj->translate($locale)->attribute_name}}">
            </div>
        @endforeach
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.attribute_value')}}</label>
            <input type="text" class="form-control" name="attribute_value" data-validation="required"
                   value="{{$obj->attribute_value}}">
        </div>
        <input type="hidden" value="{{$obj->product_id}}" name="product_id">
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
