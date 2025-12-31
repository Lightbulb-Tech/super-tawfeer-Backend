<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.command')}}</label>
            <input type="text" class="form-control" name="command" data-validation="required"
                   placeholder="{{__('main.command')}}">
        </div>
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

