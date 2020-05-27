@extends('admin.includes.body')
@section('title', 'Dashboard')
@section('subtitle','Dashboard')
@section('content')
    <div class="row">

    </div>
    <div class="row">
        @foreach(\App\Models\Service::all() as $val)
            <div class="col-12 col-md-3 col-xl-2 d-flex">
                <div class="card flex-fill">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="mb-2"></h3>
                                <div class="mb-0">Total<br/>Customers</div>
                            </div>
                            <div class="col-4 ml-auto text-right">
                                <div class="d-inline-block mt-2">
                                    <i class="feather-lg text-default" data-feather="user-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
