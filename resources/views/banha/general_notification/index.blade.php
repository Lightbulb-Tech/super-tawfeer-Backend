@extends('tamotech.layout.index')
@section('title')
    {{$bladeTitle}}
@endsection
@section('content')
    <form id="form" method="post" action="{{ $storeRoute }}" enctype="multipart/form-data">
        @csrf
        <!-- Radio Buttons for User Type Selection -->
        <div class="row">

            <div class="col-12 ">
                <label class="form-label">{{ trans('banha.type') }}</label>
                <div class="d-flex">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="recipient_type" id="specific_users"
                               value="specific_users" checked>
                        <label class="form-check-label" for="specific_users">
                            {{ trans('banha.specific_users') }}
                        </label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="recipient_type" id="all_users"
                               value="all_users">
                        <label class="form-check-label" for="all_users">
                            {{ trans('banha.all_users') }}
                        </label>
                    </div>
                </div>
            </div>

            <!-- Users Select Dropdown (shown conditionally) -->
            <div class="col-12" id="user_select_div">
                <label for="user_id" class="form-label">{{ trans('banha.users') }}</label>
                <select name="user_id[]" id="user_id" class="form-control select2" multiple>
                    <option value="" disabled>{{ __("banha.choose") }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ isset($user->first_name) && isset($user->last_name) ? $user->first_name . ' ' .  $user->last_name : __('banha.user_not_register_his_name') . ' ' . '( ' .$user->phone . ' )'}}</option>
                    @endforeach
                    {{-- {!! showSelectElement($users, 'name') !!} --}}
                </select>
            </div>
            <!-- Title Input -->
            <div class="col-12">
                <label for="title" class="form-label">{{ trans('banha.title') }}</label>
                <input type="text" name="title" data-validation="required , only_letters,limit_letters"
                       class="form-control">
            </div>

            <!-- message Textarea -->
            <div class="col-12">
                <label for="message" class="form-label">{{ trans('banha.message') }}</label>
                <textarea name="message" id="message" cols="30" rows="10" data-validation="required"
                          class="form-control"></textarea>
            </div>
        </div>
        <br>
        <!-- Submit Button -->
        {!! storeButton($storeRoute) !!}

    </form>

@endsection
@section('js')
    <script>
        $('.select2').select2();
        $.validate({
            ignore: 'input[type=hidden]',
            modules: 'date, security',
            lang: '{{\App::currentLocale()}}',
            validateOnEvent: true
        });
        $(document).ready(function () {
            const userSelectDiv = $('#user_select_div');
            const toggleUserSelect = function () {
                const selectedType = $('input[name="recipient_type"]:checked').val();
                if (selectedType === 'specific_users') {
                    userSelectDiv.show();
                } else {
                    userSelectDiv.hide();
                }
            };
            toggleUserSelect();
            $('input[name="recipient_type"]').on('change', toggleUserSelect);
        });
    </script>
@endsection
