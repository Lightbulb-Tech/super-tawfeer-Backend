<form id="form" method="post" action="{{ $storeRoute }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="TextInput" class="form-label">{{ __("permission.name") }}</label>
            <input type="text" name="name" class="form-control" data-validation="required">
        </div>
        <div class="col-6 mb-3">
            <label for="TextInput" class="form-label">{{ __("permission.display_name") }}</label>
            <input type="text" name="display_name" class="form-control" data-validation="required">
        </div>
        <div class="col-6 mb-3">
            <label for="TextInput" class="form-label">{{ __("permission.description") }}</label>
            <input type="text" name="description" class="form-control" data-validation="required">
        </div>
        <div class="col-6 mb-3">
            <label for="TextInput" class="form-label">{{ __("permission.description_ar") }}</label>
            <input type="text" name="description_ar" class="form-control" data-validation="required">
        </div>
    </div>

    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}

</form>
