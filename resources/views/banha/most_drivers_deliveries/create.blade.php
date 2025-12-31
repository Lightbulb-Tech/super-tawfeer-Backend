<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.name')}} </label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.phone')}} </label>
            <input type="text" class="form-control" name="phone">
        </div>
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.image')}}</label>
            <input type="file" class="dropify" name="image" data-validation="required">
        </div>
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

