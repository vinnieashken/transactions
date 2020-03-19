@extends('admin.includes.body')
@section('title', 'Dashboard')
@section('subtitle','Dashboard')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3></h3>
            <?php var_dump(unserialize($user->access_value)); ?>
        </div>
    </div>
@endsection
