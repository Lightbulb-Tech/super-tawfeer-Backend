<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.question')}} {!! getFieldLanguage($locale) !!}</label>
                <input type="text" class="form-control" name="{{ $locale }}[question]"
                       data-validation="required"
                       value="{{$obj->translate($locale)->question}}">
            </div>
        @endforeach
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.answer')}} {!! getFieldLanguage($locale) !!}</label>
                <textarea type="text" class="form-control" name="{{ $locale }}[answer]"
                          data-validation="required">{{$obj->translate($locale)->answer}}</textarea>
            </div>
        @endforeach
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
