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
            <div class="col-6 mb-3">
                <label for="nameBasic" class="form-label">{{__('banha.made_in_egypt')}}</label>
                <select class="form-control" name="made_in_egypt" data-validation="required">
                    <option value="">{{__("banha.choose")}}</option>
                    <option value="yes" @selected($obj->made_in_egypt == 'yes')>{{__("banha.yes")}}</option>
                    <option value="no" @selected($obj->made_in_egypt == 'no')>{{__("banha.no")}}</option>
                </select>
            </div>
            <div class="col-6 mb-3">
                <label for="nameBasic" class="form-label">{{__('banha.main_category')}}</label>
                <select class="form-control" name="main_category_id" data-validation="required">
                    <option value="">{{__("banha.choose")}}</option>
                    @foreach($main_categories as $main_category)
                        <option value="{{$main_category->id}}" @selected($main_category->id == $obj->main_category_id)>{{$main_category->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mb-3">
                <label for="nameBasic" class="form-label">{{__('banha.image')}}</label>
                <input type="file" class="dropify" name="image"
                       data-default-file="{{ image_path($obj->image) }}">
            </div>
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
