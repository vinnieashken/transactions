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
            <table id="userstable" class="table table-striped table-hover custom-list-table">
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
    <div class="modal" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ action('adduser') }}" class="form form-horizontal" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" name="fullname" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="roles" class="control-label">Roles</label>

                            <div class="form-group">
                                <label for="users" class="control-label">Product : </label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="roles[product][shortcode]" id="shortcode" value="1">
                                    <label class="form-check-label" for="shortcode">Create Shortcode</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="roles[product][service]" id="services" value="1">
                                    <label class="form-check-label" for="services">Create Service</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="users" class="control-label">Users : </label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="roles[user][add]" id="user_add" value="1">
                                    <label class="form-check-label" for="user_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="roles[user][update]" id="user_update" value="1">
                                    <label class="form-check-label" for="user_update">Update</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <div class="ml-auto">
                                <button type="submit" class="btn btn-primary">Invite Member</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
