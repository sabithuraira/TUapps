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

<!-- MAIN CSS -->
<link rel="stylesheet" href="{!! asset('assets/css/main.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/color_skins.css') !!}">
</head>

<body class="theme-blush">
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
                    <div class="top">
                        <img src="{!! asset('lucid/assets/images/logo-white.svg') !!}" alt="Lucid">
                    </div>
                    @yield('content')
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>
</html>
