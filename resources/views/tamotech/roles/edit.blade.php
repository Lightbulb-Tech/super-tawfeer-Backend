@extends('tamotech.layout.index')
@section('title')
    {{__('main.roles')}}
@endsection
@section('content')
    <form method="POST" action="{{ route('roles.update', $role->id) }}" id="editForm">
        @csrf
        @method('PUT') {{-- Use PUT method for updating --}}
        <div class="row">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <p class="card-title  mt-2 mb-2">{{__('permission.permission name')}}</p>
                                <input type="text" name="name" class="form-control" value="{{ $role->name }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <p class="card-title mt-2 mb-2">{{ __('permission.permission display_name') }}</p>
                                <input type="text" name="display_name" class="form-control"
                                       value="{{ $role->display_name }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <p class="card-title mt-2 mb-2">{{ __('permission.permission description') }}</p>
                                <input type="text" name="description" class="form-control"
                                       value="{{ $role->description }}">
                            </div>
                        </div>
                        <h4 class="mt-3">{{__('permission.select the permissions that this person will able to control')}}</h4>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-check custom-checkbox mb-3 checkbox-info">
                                    <input type="checkbox" class="form-check-input" id="chooseAll">
                                    <label class="form-check-label"
                                           for="chooseAll">{{__('permission.choose all')}}</label>
                                </div>
                            </div>
                            @foreach($permissions as $permission)
                                <div class="col-3">
                                    <div class="form-check custom-checkbox mb-3 checkbox-success">
                                        <input type="checkbox" class="form-check-input permission-checkbox"
                                               name="permission[]" id="{{ 'permission_' . $permission->id }}"
                                               value="{{ $permission->id }}"
                                               @if(in_array($permission->id, $rolePermissions)) checked @endif>
                                        <label class="form-check-label"
                                               for="{{ 'permission_' . $permission->id }}"> @if (app()->getLocale() == 'ar')
                                                {{ $permission->description_ar ?? $permission->description }}
                                            @else
                                                {{ $permission->description }}
                                            @endif</label>
                                    </div>
                                </div>
                            @endforeach
                            <!-- col -->
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="button" id="submitForm"
                                        class="btn btn-md btn-success">{{__('permission.save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@section('js')
    <script>
        $(document).ready(function () {

            $.validate({
                ignore: 'input[type=hidden]',
                modules: 'date, security',
                lang: '{{\App::currentLocale()}}',
                validateOnEvent: true
            });

            $('#chooseAll').click(function () {
                $('.permission-checkbox').prop('checked', $(this).prop('checked'));
            });

            $('#submitForm').click(function () {
                let $submitBtn = $(this);
                $submitBtn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>{{ __("main.loading") }}')
                    .prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: $('#editForm').attr('action'), // Use the correct form ID
                    data: $('#editForm').serialize(),
                    success: function (response) {
                        if(response.code === 200){
                            handleSuccessResponce(response);
                            setTimeout(function () {
                                window.location.href = response.data.url;
                            }, 1000);
                        }
                    },
                    error: function (response) {
                        handleErrorResponce(response)
                    }
                });
            });
        });


    </script>
@endsection
