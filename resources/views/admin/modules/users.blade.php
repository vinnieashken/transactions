@extends('admin.includes.body')
@section('title', 'User Management')
@section('subtitle','User Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="text-right">
                <button class="btn btn-default" data-toggle="modal" data-target="#addModal">
                    <i class="align-middle" data-feather="plus"></i> Add User
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="users-table" class="table table-striped table-hover custom-list-table">
                <thead>
                <tr>
                    <th>*</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>*</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
@endsection
