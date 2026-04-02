@extends('fe.profile')

@section('content')
<div class="container-fluid py-5" style="min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            @include('fe.reservasi')
        </div>
    </div>
</div>
@endsection