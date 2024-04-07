<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: @yield('title')</title>
		@include('admin.partiels.style')
	</head>
	<body class="hold-transition login-page">
        @yield('main')
		@include('admin.partiels.script')
	</body>
</html>
