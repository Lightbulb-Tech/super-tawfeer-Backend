<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.name')}} </label>
            <input type="text" class="form-control" name="name" value="{{$obj->name}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.phone')}} </label>
            <input type="text" class="form-control" name="phone" value="{{$obj->phone}}">
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
