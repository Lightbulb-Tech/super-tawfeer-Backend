<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label for="nameBasic"
                   class="form-label text-danger">{{__('banha.available_drivers')}}</label>
            <select class="form-control" name="driver_id" data-validation="required">
                <option value="">{{__('banha.choose')}}</option>
                @foreach($drivers as $driver)
                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="order_id" value="{{$order_id}}">
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

