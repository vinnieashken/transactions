@extends('admin.includes.body')
@section('title', 'Dashboard')
@section('subtitle','Dashboard')
@section('content')
    <div class="row">
        <div class="d-flex justify-content-end">

        </div>
    </div>
    <div class="row">
        @foreach(\App\Models\Service::all() as $val)
            <div class="col-12 col-md-3 col-xl-2 d-flex">
                <div class="card flex-fill">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2">{{ $val->service_name }}</h3>
                                <div class="mb-0">
                                    Ksh {{ number_format($report[$val->service_name],2) }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
