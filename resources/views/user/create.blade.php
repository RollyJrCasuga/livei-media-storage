@extends('layout')

@section('content')
<div class="user-create d-flex justify-content-center mt-5">
    <div class="card">
    <div class="card-header">
    <a class="btn btn-light mb-2" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
    <h4 class="mt-2">New User</h4>
    </div>
    <div class="card-body">
        <form id="upload-form" method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="form-group">
                <label for="">First Name:</label>
                <input type="text" class="form-control" name="first_name"/>
            </div>
            <div class="form-group">
                <label for="">Last Name:</label>
                <input type="text" class="form-control" name="last_name"/>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email"/>
            </div>
            <div class="form-group">
            <label for="">Account Type</label>
            <select id="" class="form-control" name="account_type">
                <option selected>Select...</option>
                <option>Admin</option>
                <option>Staff</option>
            </select>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="password"/>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Create</button>
        </form>
    </div>
</div>
</div>

@endsection
