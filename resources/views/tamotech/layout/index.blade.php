<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
      class="light-style layout-navbar-fixed layout-menu-fixed layout-compact "
      @if(LaravelLocalization::getCurrentLocale() == 'en') dir="ltr" @else dir="rtl" @endif
      data-theme="theme-dark"
      data-assets-path="{{ asset('admin') }}/assets/"
      data-template="vertical-menu-template">
<head>

    @include('tamotech.includes.meta')
    <!-- Canonical SEO -->
    @include('tamotech.includes.css')
</head>
<body>
<!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0"
            style="display: none; visibility: hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-{{$modelSize ?? 'xl'}}" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                {{--                <div class="modal-footer">--}}
                {{--                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>--}}
                {{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
    <div class="layout-container">
        <!-- Menu -->
        @include('tamotech.layout.sidebar')
        <!-- / Menu -->
        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('tamotech.layout.header')
            <!-- / Navbar -->
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
                <!-- / Content -->
                <!-- Footer -->
                @include('tamotech.layout.footer')
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>


    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>


    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
@include('tamotech.includes.js')
@include('tamotech.includes.custom_js')
@yield('js')
</body>

</html>

<!-- beautify ignore:end -->


