<form id="form" method="post" action="{{ $updateRoute }}" enctype="multipart/form-data">
    @method('Put')
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="TextInput" class="form-label">{{ __("permission.description") }}</label>
            <input type="text" name="description" value="{{ $obj->description }}" class="form-control"
                   data-validation="required">
        </div>
        <div class="col-6 mb-3">
            <label for="TextInput" class="form-label">{{ __("permission.description_ar") }}</label>
            <input type="text" name="description_ar" value="{{ $obj->description_ar }}" class="form-control"
                   data-validation="required">
        </div>
    </div>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}
</form>
