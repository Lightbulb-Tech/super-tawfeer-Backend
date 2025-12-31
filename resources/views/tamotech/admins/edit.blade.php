<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.name')}}</label>
            <input type="text" class="form-control" name="name" data-validation="required" value="{{$obj->name}}"
                   placeholder="{{__('main.hintName')}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.email')}}</label>
            <input type="email" class="form-control" name="email" data-validation="required , email"
                   placeholder="{{__('main.hintEmail')}}" value="{{$obj->email}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.phone')}}</label>
            <input type="number" class="form-control" name="phone" data-validation="required , length"
                   data-validation-length="max11" placeholder="{{__('main.hintPhone')}}" value="{{$obj->phone}}">
        </div>
        <div class="col-6 mb-3">
            <label for="roles" class="form-label">{{ __('permission.roles') }}</label>
            <select name="role_id" id="roles" class="form-control "  data-validation="required">
                <option value="">{{ __('permission.choose') }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, $obj->roles->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.image')}}</label>
            <input type="file" class="dropify" name="image" data-default-file="{{  asset('storage/'.$obj->image)}}">
        </div>
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
