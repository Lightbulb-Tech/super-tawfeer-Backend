<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
      class="light-style layout-wide customizer-hide"
      @if(LaravelLocalization::getCurrentLocale() == 'en') dir="ltr" @else dir="rtl" @endif
      data-theme="theme-default"
      data-assets-path="{{ asset('admin') }}/assets/"
      data-template="vertical-menu-template">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>{{__('auth.login')}}</title>
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5"/>
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://1.envato.market/vuexy_admin">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="{{asset('')}}admin/assets/vendor/libs/toastr/toastr.css"/>
    <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5J3LMKC');</script>
    <!-- End Google Tag Manager -->

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('admin')}}/assets/img/favicon/favicon.ico"/>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
            rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/fonts/fontawesome.css"/>
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/fonts/tabler-icons.css"/>
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/fonts/flag-icons.css"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/css/rtl/core.css"
          class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/css/rtl/theme-default.css"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset('admin')}}/assets/css/demo.css"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/node-waves/node-waves.css"/>
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/typeahead-js/typeahead.css"/>
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/@form-validation/umd/styles/index.min.css"/>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/css/pages/page-auth.css">

    <!-- Helpers -->
    <script src="{{asset('admin')}}/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{asset('admin')}}/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin')}}/assets/js/config.js"></script>

</head>

<body>


<!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0"
            style="display: none; visibility: hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Content -->

<div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row min-vh-100 g-0">
        <!-- Left Image -->


        <!-- Right Side (Login) -->
        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
            <div class="w-px-400 mx-auto">
                <!-- Logo -->
                <div class="app-brand mb-4 text-center d-flex flex-column align-items-center">
                    <!-- اللوجو -->
                    <img src="{{ asset('admin/images/image_dashboard.jpg') }}" alt="Logo"
                         style="width: 120px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-bottom: 10px;">

                    <!-- العنوان الرئيسي -->
                    <h3 class="fw-bold text-primary mb-2">
                        {{__("main.smart_control_panel")}}
                    </h3>

                    <!-- النص التعريفي -->
                    <p class="text-muted" style="font-size: 0.90rem; max-width: 400px;">
                        {{__("main.full_control")}}
                    </p>
                </div>


                <!-- /Logo -->
                <h3 class="mb-1">{{ __('auth.welcomeBack') }} 👋</h3>
                <p class="mb-4">{{ __('auth.loginText') }}</p>

                <form id="formAuth" class="mb-3" action="{{ route('checkLogin') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('auth.email') }}</label>
                        <input type="text" class="form-control" id="email" name="email" data-validation="required , email"
                               placeholder="{{ __('main.enter_your_email') }}" autofocus>
                    </div>

                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">{{ __('auth.password') }}</label>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password" data-validation="required"
                                   placeholder="••••••••••••"
                                   aria-describedby="password"/>
                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>

                    <button id="btnLogin" type="submit" class="btn btn-primary d-grid w-100">
                        {{ __('auth.login') }}
                    </button>
                </form>
            </div>
        </div>
        <div class="d-none d-lg-flex col-lg-7">
            <div class="w-100 h-100">
                <img src="{{ asset('admin/images/photo.jpeg') }}"
                     alt="custom-image"
                     class="w-100 h-100 object-fit-cover" style="object-fit: cover;" />
            </div>
        </div>
    </div>

</div>

<!-- / Content -->


{{--<div class="buy-now">--}}
{{--    <a href="https://1.envato.market/vuexy_admin" target="_blank" class="btn btn-danger btn-buy-now">Buy Now</a>--}}
{{--</div>--}}


<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset('admin')}}/assets/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function () {
        $('#formAuth').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    document.getElementById("btnLogin").innerHTML = "{{__('auth.loggingIn') . '....'}}";
                },
                success: function (response) {
                    if (response.data.messageSuccess) {
                        toastr.success(response.data.messageSuccess)
                        setTimeout(function () {
                            window.location.href = response.data.redirect
                        }, 1000)
                    }
                    if (response.data.messageFail)
                    {
                        toastr.error(response.data.messageFail)
                    }
                },
                complete: function () {
                    document.getElementById("btnLogin").innerHTML = `{{ __('auth.login') }}`;
                },
                error: function (xhr, status, error) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + '<br>';
                    });
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        html: errorMessage,
                    });
                }
            })
        })
    });
</script>
<script src="{{asset('admin')}}/assets/vendor/libs/jquery/jquery.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/popper/popper.js"></script>
<script src="{{asset('admin')}}/assets/vendor/js/bootstrap.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/hammer/hammer.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/i18n/i18n.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="{{asset('admin')}}/assets/vendor/js/menu.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip."></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('admin')}}/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
<script src="{{asset('admin')}}/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>

<!-- Main JS -->
<script src="{{asset('admin')}}/assets/js/main.js"></script>


<!-- Page JS -->
<script src="{{asset('admin')}}/assets/js/pages-auth.js"></script>
@include('tamotech.includes.jqueryValidation')
</body>

</html>

<!-- beautify ignore:end -->


