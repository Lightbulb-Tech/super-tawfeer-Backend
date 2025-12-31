<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.title')}} </label>
            <input type="text" class="form-control" name="title" value="{{$obj->title}}">
        </div>
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
