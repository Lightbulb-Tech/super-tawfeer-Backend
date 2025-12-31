<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/select2/select2.css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/bootstrap-select/bootstrap-select.css"/>
<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.type')}}</label>
            <select class="form-control" name="type" id="type">
                <option value="">{{{__("banha.choose")}}}</option>
                @foreach($types as $type)
                    <option
                            value="{{$type->value}}" {{$type->value == $obj->type ? 'selected' :''}}>{{\App\Enums\SliderTypeisEnum::tryFrom($type->value)->lang()}}</option>
                @endforeach
            </select>
        </div>
        <div id="moduleNameDiv" style="display: none">
            <div class="col-12 mb-3">
                <label for="nameBasic" class="form-label">{{__('banha.module_name')}}</label>
                <select class="form-control" name="module_name" id="module_name">
                    <option value="">{{{__("banha.choose")}}}</option>
                    @foreach($moduleNames as $moduleName)
                        <option
                                value="{{$moduleName->value}}" {{$moduleName->value == $obj->module_name ? 'selected' :''}}>{{\App\Enums\ModulesTypeisEnum::tryFrom($moduleName->value)->lang()}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="productsDiv" style="display: none">
            <div class="col-12 mb-3">
                <label for="select2Basic2" class="form-label">{{__('banha.products')}}</label>
                <select id="select2Basic2" class="form-control select2" name="module_id" data-allow-clear="true">
                    <option value="">{{{__("banha.choose")}}}</option>
                    @foreach($products as $key=> $product)
                        <option
                                value="{{$key}}" {{$key == $obj->module_id ? 'selected' :''}}>{{$product}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="categoriesDiv" style="display: none">
            <div class="col-12 mb-3">
                <label for="select2Basic" class="form-label">{{__('banha.categories')}}</label>
                <select id="select2Basic" class="form-control select2" name="module_id" data-allow-clear="true">
                    <option value="">{{{__("banha.choose")}}}</option>
                    @foreach($categories as $key=> $category)
                        <option value="{{$key}}" {{$key == $obj->module_id ? 'selected' :''}}>{{$category}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.image')}}</label>
            <input type="file" class="dropify" name="image"    data-default-file="{{ image_path($obj->image) }}">
        </div>
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
<script src="{{asset('admin')}}/assets/vendor/libs/select2/select2.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="{{asset('admin')}}/assets/js/forms-selects.js"></script>
