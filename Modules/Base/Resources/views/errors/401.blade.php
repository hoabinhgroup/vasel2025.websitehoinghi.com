@extends('base::cmspanel.layout.dashboard')

@section('content')
<style>
    .error-code {
    font-size: 10rem;
    }
</style>
<section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-lg-4 col-md-8 col-10 p-0">
            <div class="card-header bg-transparent border-0">
                    <h2 class="error-code text-center mb-2">401</h2>
                    <h3 class="text-uppercase text-center">Bạn không được phép truy cập vào chức năng này.</h3>
            </div>
        </div>
    </div>
</section>
@stop
