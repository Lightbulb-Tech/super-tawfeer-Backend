<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.attribute_name')}} {!! getFieldLanguage($locale) !!}</label>
                <input type="text" class="form-control" name="{{ $locale }}[attribute_name]">
            </div>
        @endforeach
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.attribute_value')}}</label>
            <input type="text" class="form-control" name="attribute_value" data-validation="required">
        </div>
        <input type="hidden" value="{{$productId}}" name="product_id">
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

