<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        <label for="nameBasic" class="form-label">{{__('main.command')}}</label>
        <input type="text" class="form-control" name="command" data-validation="required"
               placeholder="{{__('main.command')}}" value="{{$obj->command}}">
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
