@extends('be.master')
@section ('navbar')
    @include('be.navbar')
@endsection
@section ('sidebar')
    @include('be.sidebar')
@endsection
@section ('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    </div>

<!-- Welcome Card -->
<div class="alert alert-primary shadow-sm">
    <h5 class="mb-1">Selamat Datang, Admin!</h5>
    <p class="mb-0">Semoga harimu menyenangkan 🎉 —</p>
</div>
@endsection
@section('footer')
    @include('be.footer')
@endsection