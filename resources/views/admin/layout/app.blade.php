<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: @yield('title')</title>
		@include('admin.partiels.style')
		<meta name="csrf-token" content="{{ csrf_token() }}" />
	</head>
	<body class="hold-transition sidebar-mini">
		<div class="wrapper">
			@include('admin.partiels.nav')
			@include('admin.partiels.sidebar')
    @yield('main')
			@include('admin.partiels.footer')
		</div>
		@include('admin.partiels.script')
		<script type="text/javascript">
			$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});
		</script>
		@yield('customJS')
	</body>
</html>


