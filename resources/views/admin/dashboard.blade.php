@extends('layout.mastar')

@section("title")
    dashboard
@endsection

@section('class')
    sidebar-mini
@endsection

{{-- @section("main")
    <h1>wellcome</h1>
    @if (Session::has('session'))
        <x-alert type="success" >
            {{ session('session') }}
        </x-alert>
    @endif

    <a href={{ route("admin.logOut") }}>logout</a>
@endsection --}}

@section("main")
    <div class="wrapper">
        @include('admin.partiels.nav')
        @include('admin.partiels.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        @include('admin.partiels.footer')
    </div>
@endsection


