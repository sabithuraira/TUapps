<!doctype html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME', 'MUSI') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
    <meta name="author" content="WrapTheme, design by: ThemeMakker.com">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/font-awesome/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/chartist/css/chartist.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/toastr/toastr.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/multi-select/css/multi-select.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/nouislider/nouislider.min.css') !!}" />

    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{!! asset('assets/css/main.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/color_skins.css') !!}">
    @yield('css')
</head>

<body class="theme-cyan">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="{!! asset('lucid/assets/images/logo-icon.svg') !!}" width="48" height="48" alt="Musi.."></div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- Overlay For Sidebars -->

    <div id="wrapper">
        @include('layouts.header')

        @include('layouts.left_bar')

        <div id="main-content">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-5 col-md-8 col-sm-12">
                            @yield('breadcrumb')
                        </div>
                    </div>
                </div>

                @yield('content')

            </div>
        </div>

    </div>

    <!-- Javascript -->

    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="{{ asset('lucid/assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('lucid/assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('lucid/assets/vendor/multi-select/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('lucid/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('lucid/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    {{-- <script src="{{ asset('lucid/assets/vendor/nouislider/nouislider.js') }}"></script> --}}

    {{-- <script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script> --}}

    <script src="{{ asset('lucid/assets/vendor/select2/select2.min.js') }}"></script>

    <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
    <script src="{{ asset('lucid/assets/vendor/toastr/toastr.js') }}"></script>


    <script src="{{ asset('lucid/assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    {{-- <script src="{!! asset('assets/js/index.js') !!}"></script> --}}

    @yield('scripts')
</body>

</html>
