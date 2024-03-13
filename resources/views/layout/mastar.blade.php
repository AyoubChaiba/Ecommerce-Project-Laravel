<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: @yield('title')</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset("admin-assets/plugins/fontawesome-free/css/all.min.css") }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset("admin-assets/css/adminlte.min.css") }}">
		<link rel="stylesheet" href="{{ asset("admin-assets/css/custom.css") }}">
	</head>
	<body class="hold-transition @yield('class')">
        @yield('main')
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{ asset("admin-assets/plugins/jquery/jquery.min.js") }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset("admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset("admin-assets/js/adminlte.min.js") }}"></script>
	</body>
</html>