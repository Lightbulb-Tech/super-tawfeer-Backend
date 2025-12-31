<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.title')}} </label>
            <input type="text" class="form-control" name="title">
        </div>
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

