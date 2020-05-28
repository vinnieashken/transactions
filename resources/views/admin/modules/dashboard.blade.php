@extends('admin.includes.body')
@section('title', 'Dashboard')
@section('subtitle','Dashboard')
@section('content')
    <div class="d-flex justify-content-end w-100">
            <div class="ml-auto">
                <div id="reportrange" class="overflow-hidden form-control">
                    <i class="far fa-calendar"></i>&nbsp;
                    <span></span> <i class="fas fa-caret-down"></i>
                </div>
            </div>
    </div>

    <div class="row mt-2">
       
        @foreach(\App\Models\Service::all() as $val)
            <div class="col-12 col-md-3 col-xl-3 d-flex">
                <div class="card flex-fill">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2">{{ ucfirst($val->service_name) }}</h3>
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
