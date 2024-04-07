@extends('admin.layout.login')

@section('title')
	login Administrative
@endsection

@section('main')
	<div class="login-box">
		@if (Session::has('error'))
			<x-alert type="danger" >
				{{ session('error') }}
			</x-alert>
		@endif
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="#" class="h3">Administrative Panel</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Sign in to start your session</p>
				<form action={{ route("admin.login") }} method="post">
					@csrf
					<div class="input-group mb-3">
						<input type="email" name="email" id="email" class="form-control @error('email')
							is-invalid
						@enderror" placeholder="Email"
						value="{{ old("email") }}"
						>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					@error('email')
						<p class="text-red" >{{ $message }}</p>
					@enderror
					<div class="input-group mb-3">
						<input type="password" name="password" class="form-control @error('email')
						is-invalid
					@enderror" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
						@error('password')
							<p class="text-red">{{ $message }}</p>
						@enderror
					<div class="row">
						{{-- <div class="col-8">
							<div class="icheck-primary">
								<input type="checkbox" id="remember">
								<label for="remember">
									Remember Me
								</label>
							</div>
						</div> --}}
						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Login</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<p class="mb-1 mt-3">
					<a href="forgot-password.html">I forgot my password</a>
				</p>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
@endsection
