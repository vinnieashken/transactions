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
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="#" class="edit-item" data-toggle="modal" data-target="#editModal" data-id="" data-shortcode="">
                                <i class="align-middle" data-feather="edit-2"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Shortcode</th>
                        <th>Type</th>
                        <th>Creator</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
