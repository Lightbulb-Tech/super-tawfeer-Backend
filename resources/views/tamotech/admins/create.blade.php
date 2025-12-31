<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.name')}}</label>
            <input type="text" class="form-control" name="name" data-validation="required"
                   placeholder="{{__('main.hintName')}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.email')}}</label>
            <input type="email" class="form-control" name="email" data-validation="required , email"
                   placeholder="{{__('main.hintEmail')}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.phone')}}</label>
            <input type="number" class="form-control" name="phone" data-validation="required , length"
                   data-validation-length="max11" placeholder="{{__('main.hintPhone')}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label"> {{ __('permission.roles') }} </label>
            <select name="role_id" class="form-control" data-validation="required">
                <option value="">{{__('permission.choose')}}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.password')}}</label>
            <input class="form-control" type="password" name="password"
                   data-validation="required , confirmation , length" data-validation-length="min4"
                   placeholder="{{__('main.hintPassword')}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.confirmPassword')}}</label>
            <input class="form-control" type="password" name="password_confirmation" data-validation="required"
                   placeholder="{{__('main.hintConfirmPassword')}}">
        </div>
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('main.image')}}</label>
            <input type="file" class="dropify" name="image" data-validation="required">
        </div>

    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

