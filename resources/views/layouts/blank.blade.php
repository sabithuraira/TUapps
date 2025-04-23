<!doctype html>
<html lang="en">

<head>
<title>{{ env('APP_NAME', 'MUSI') }}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap/css/bootstrap.min.css') !!}">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/font-awesome/css/font-awesome.min.css') !!}">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/animate-css/animate.min.css') !!}">

<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />

<!-- MAIN CSS -->
<link rel="stylesheet" href="{!! asset('assets/css/main.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/color_skins.css') !!}">
</head>

<body class="theme-cyan">
	<!-- WRAPPER -->
	<div id="wrapper">
        @yield('content')	
	</div>
	<!-- END WRAPPER -->



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
    @yield('scripts')
</body>
</html>
