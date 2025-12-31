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
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.made_in_egypt')}}</label>
            <select class="form-control" name="made_in_egypt" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                <option value="yes">{{__("banha.yes")}}</option>
                <option value="no">{{__("banha.no")}}</option>
            </select>
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.image')}}</label>
            <input type="file" class="dropify" name="image" data-validation="required">
        </div>
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

