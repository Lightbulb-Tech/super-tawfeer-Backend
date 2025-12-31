<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.model')}} </label>
            <input type="text" class="form-control" name="model" value="{{$obj->model}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.price_of_km')}} </label>
            <input type="number" class="form-control" name="price_of_km" min="0.01" step="0.01"
                   value="{{$obj->price_of_km}}">
        </div>
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.image')}}</label>
            <input type="file" class="dropify" name="image" data-default-file="{{ image_path($obj->image) }}">
        </div>
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
