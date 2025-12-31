@extends('tamotech.layout.index')
@section('title')
    {{__('main.profile')}}
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);">
                        <i class="ti-xs ti ti-users me-1"></i> Account</a></li>
                <li class="nav-item"><a class="nav-link" href="pages-account-settings-security.html">
                        <i class="ti-xs ti ti-lock me-1"></i> Security</a></li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        @if(isset($admin->image))
                            <img src="{!! image_path($admin->image) !!}" alt="user-avatar"
                                 class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar"/>
                        @else
                            <img src="{{asset('admin/assets/default_image.png')}}" alt="user-avatar"
                                 class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar"/>
                        @endif
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" hidden
                                       accept="image/png, image/jpeg"/>
                            </label>
                            <button type="button"
                                    class="btn btn-label-secondary account-image-reset mb-3">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>
                            <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="firstName" class="form-label">Name</label>
                                <input class="form-control" type="text" id="firstName" name="firstName"
                                       value="{{$admin->name}}" autofocus/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="text" id="email" name="email"
                                       value="{{$admin->email}}" placeholder="john.doe@example.com"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="phoneNumber" name="phone"
                                           class="form-control" value="{{$admin->phone}}" placeholder="202 555 0111"/>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="card">
                <h5 class="card-header">Delete Account</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h5 class="alert-heading mb-1">Are you sure you want to delete your
                                account?</h5>
                            <p class="mb-0">Once you delete your account, there is no going back. Please
                                be certain.</p>
                        </div>
                    </div>
                    <form id="formAccountDeactivation" onsubmit="return false">
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="accountActivation"
                                   id="accountActivation"/>
                            <label class="form-check-label" for="accountActivation">I confirm my account
                                deactivation</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account">Deactivate
                            Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

    </script>
@endsection
