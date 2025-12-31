<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.question')}} {!! getFieldLanguage($locale) !!}</label>
                <input type="text" class="form-control" name="{{ $locale }}[question]">
            </div>
        @endforeach
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.answer')}} {!! getFieldLanguage($locale) !!}</label>
                <textarea type="text" class="form-control" name="{{ $locale }}[answer]"></textarea>
            </div>
        @endforeach
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

