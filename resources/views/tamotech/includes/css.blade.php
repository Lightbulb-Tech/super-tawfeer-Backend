<link rel="canonical" href="https://1.envato.market/vuexy_admin">
{{--<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600;700&display=swap" rel="stylesheet">--}}

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
@if(isset($settings))
    <link rel="icon" type="image/x-icon" href="{!! image_path($settings->icon) !!}"/>
@else
    <link rel="icon" type="image/x-icon" href="{{asset('admin')}}/assets/img/favicon/favicon.ico"/>
@endif
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
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/css/rtl/core.css" class="template-customizer-core-css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/css/rtl/theme-default.css"
      class="template-customizer-theme-css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/css/demo.css"/>

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/node-waves/node-waves.css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/typeahead-js/typeahead.css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/apex-charts/apex-charts.css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/swiper/swiper.css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/select2/select2.css"/>
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/bootstrap-select/bootstrap-select.css"/>

<link rel="stylesheet"
      href="{{asset('admin')}}/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css">
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
<link rel="stylesheet"
      href="{{asset('admin')}}/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css">

<!-- Page CSS -->
<link rel="stylesheet" href="{{asset('admin')}}/assets/vendor/css/pages/cards-advance.css"/>

<!-- Helpers -->
<script src="{{asset('admin')}}/assets/vendor/js/helpers.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
{{--<script src="{{asset('admin')}}/assets/vendor/js/template-customizer.js"></script>--}}
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{asset('admin')}}/assets/js/config.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
     alpha/css/bootstrap.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<link rel="stylesheet" href="{{asset('')}}admin/assets/vendor/libs/@form-validation/umd/styles/index.min.css"/>
<link rel="stylesheet" href="{{asset('')}}admin/assets/vendor/libs/sweetalert2/sweetalert2.css"/>
<link rel="stylesheet" href="{{asset('')}}admin/assets/vendor/libs/toastr/toastr.css"/>
{{--<!-- Toastr -->--}}
{{--<link rel="stylesheet" href="{{asset('Admin/vuexy-html-admin-template')}}/assets/toastr/toastr.min.css">--}}
{{--<!-- SweetAlert2 -->--}}
{{--<link rel="stylesheet" href={{asset('Admin/vuexy-html-admin-template')}}/assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">--}}
<script src="http://demo.javatpoint.com/plugin/jquery.js"></script>
<link rel="stylesheet" href="http://demo.javatpoint.com/plugin/bootstrap-3.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<link rel="stylesheet" href="{{asset('')}}admin/assets/vendor/css/pages/app-chat.css">
<link rel="stylesheet" href="{{asset('')}}admin/assets/cssbundle/dropify.min.css">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('admin/assets/vendor/libs/dropify/js/dropify.min.js') }}"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<style>
    #toast-container > div.toast-success .toast-progress {
        background-color: #28a745 !important; /* أخضر */
    }

    #toast-container > div.toast-error .toast-progress {
        background-color: #dc3545 !important; /* أحمر */
    }

    #toast-container > div.toast-info .toast-progress {
        background-color: #17a2b8 !important; /* أزرق */
    }

    #toast-container > div.toast-warning .toast-progress {
        background-color: #ffc107 !important; /* أصفر */
    }

</style>
@yield('style')
