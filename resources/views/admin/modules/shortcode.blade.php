@extends('admin.includes.body')
@section('title', 'Shortcode')
@section('subtitle','Shortcode')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="text-right"><button class="btn btn-default" data-toggle="modal" data-target="#addModal">
                    <i class="align-middle" data-feather="plus"></i> Add Shortcode</button>
            </div>
        </div>
        <div class="card-body">
            <table id="datatables-buttons" class="table table-striped table-hover custom-list-table">
                <thead>
                    <tr>
                        <th>Shortcode</th>
                        <th>Type</th>
                        <th>Creator</th>
                        <th>Notifying</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortcode as $value)
                    <tr>
                        <td>{{ $value->shortcode }}</td>
                        <td>{{ $value->shortcode_type }}</td>
                        <td>{{ App\User::where('id',$value->user_id)->first()->name }}</td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input shortcode-notify" data-shortcode="{{ $value }}" @if($value->status == 1) disabled checked=""  @endif value="Y" id="active-{{ $value->id }}">
                                <label class="custom-control-label" for="active-{{ $value->id }}"></label>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="edit-shortcode" data-shortcode="{{ App\Models\Shortcode::where('id',$value->id)->first() }}">
                                <i class="align-middle" data-feather="edit-2"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Shortcode</th>
                        <th>Type</th>
                        <th>Creator</th>
                        <th>Notifying</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            <div class="d-flex justify-content-end w-100">
                {{ $shortcode->links() }}
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Shortcode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ url('saveshortcode') }}" class="form create_form" method="post">
                </div>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="add-shortcode">Shortcode</label>
                            <input type="text" class="form-control" name="shortcode" id="add-shortcode">
                        </div>
                    <div class="form-group">
                        <label for="add-shortcode_type">Type</label>
                        <input type="text" class="form-control" name="type" id="add-shortcode_type">
                    </div>
                    <div class="form-group">
                        <label for="add-consumerkey">Consumer Key</label>
                        <input type="text" class="form-control" name="consumerkey" id="add-consumerkey">
                    </div>
                    <div class="form-group">
                        <label for="add-consumersecret">Consumer Secret</label>
                        <input type="text" class="form-control" name="consumersecret" id="add-consumersecret">
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Shortcode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ action('editshortcode') }}" class="form create_form" method="post">
                </div>
                <div class="modal-body" id="editSc">
                    @csrf
                    <input type="text" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="edit-shortcode">Shortcode</label>
                        <input type="text" class="form-control" name="shortcode" id="edit-shortcode">
                    </div>
                    <div class="form-group">
                        <label for="edit-shortcode_type">Type</label>
                        <input type="text" class="form-control" name="type" id="edit-shortcode_type">
                    </div>
                    <div class="form-group">
                        <label for="edit-consumerkey">Consumer Key</label>
                        <input type="text" class="form-control" name="consumerkey" id="edit-consumerkey">
                    </div>
                    <div class="form-group">
                        <label for="edit-consumersecret">Consumer Secret</label>
                        <input type="text" class="form-control" name="consumersecret" id="edit-consumersecret">
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
