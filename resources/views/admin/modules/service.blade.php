@extends('admin.includes.body')
@section('title', 'Services')
@section('subtitle','services')
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="text-right">
                <button class="btn btn-default" data-toggle="modal" data-target="#addModal">
                    <i class="align-middle" data-feather="plus"></i> Add Service
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="datatables-buttons" class="table table-striped table-hover custom-list-table">
                <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Shortcode</th>
                    <th>Prefix</th>
                    <th>Callback Url</th>
                    <th>Verification Url</th>

                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($services as $value)
                    <tr>
                        <td>{{ $value->service_name }}</td>
                        <td>{{ App\Models\Shortcode::where('id', $value->shortcode_id)->first()->shortcode }}</td>
                        <td>{{ $value->prefix }}</td>
                        <td>{{ $value->callback_url }}</td>
                        <td>{{ ($value->verification_url != null)?$value->verification_url:'NULL' }}</td>
                        <td>
                            <a href="#" class="edit-service" data-service="{{ $value }}">
                                <i class="align-middle" data-feather="edit-2"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Service Name</th>
                    <th>Shortcode</th>
                    <th>Prefix</th>
                    <th>Callback Url</th>
                    <th>Verification</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
            <div class="d-flex justify-content-end w-100">
                {{ $services->links() }}
            </div>

        </div>
    </div>
    @php
    $shortcode = App\Models\Shortcode::all();
    @endphp
    <div class="modal" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title">Add Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ url('addservice') }}" method="post" class="form form-horizontal create_form">
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group form-row">
                        <div class="col">
                            <label for="add-shortcode" class="control-label">Shortcode</label>
                            <select name="shortcode" id="add-shortcode" class="custom-select">
                                @foreach($shortcode as $value)
                                <option value="{{ $value->id }}">{{ $value->shortcode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="add-code-prefix" class="control-label">Code Prefix</label>
                            <input type="text" name="prefix" id="add-code-prefix" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="add-service-name" class="control-label">Service Name</label>
                        <input type="text" name="service_name" id="add-service-name" class="form-control">
                    </div>
                     <div class="form-group">
                         <label for="add-description" class="control-label">Service Description</label>
                         <input type="text" name="description" id="add-description" class="summernote">
                     </div>
                    <div class="form-group">
                        <label for="add-verification-callback" class="control-label">Verification Callback</label>
                        <input type="text" name="verification_callback" id="add-verification-callback" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="add-response-callback" class="control-label">Response Callback</label>
                        <input type="text" name="response_callback" id="add-response-callback" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ url('editservice') }}" method="post" class="form form-horizontal create_form">
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group form-row">
                        <div class="col">
                            <label for="edit-shortcode" class="control-label">Shortcode</label>
                            <select name="shortcode" id="edit-shortcode" class="form-control">
                                @foreach($shortcode as $value)
                                    <option value="{{ $value->id }}">{{ $value->shortcode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="edit-code-prefix" class="control-label">Code Prefix</label>
                            <input type="text" name="prefix" id="edit-code-prefix" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-service-name" class="control-label">Service Name</label>
                        <input type="text" name="service_name" id="edit-service-name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-description" class="control-label">Service Description</label>
                        <input type="text" name="description" id="edit-description" class="summernote">
                    </div>
                    <div class="form-group">
                        <label for="edit-verification-callback" class="control-label">Verification Callback</label>
                        <input type="text" name="verification_callback" id="edit-verification-callback" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-response-callback" class="control-label">Response Callback</label>
                        <input type="text" name="response_callback" id="edit-response-callback" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
