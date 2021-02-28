@extends('layout')

@section('content')
<div class="user-edit d-flex justify-content-center card-wrapper">
  <div class="card">
    <div class="card-header">
        <a class="btn btn-light mb-2" href="{{ route('user.index') }}"><i class="fas fa-arrow-left"></i></a>
        <h4 class="mt-2">Update User</h4>
    </div>
    <div class="card-body pt-1 pt-md-0">        
        <form class="mt-3" method="post" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="form-group file-name">
                <label for="country_name">First Name:</label>
                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}"/>
            </div>
            <div class="form-group file-name">
                <label for="country_name">Last Name:</label>
                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}"/>
            </div>
            <div class="form-group">
            <label for="">Account Type</label>
            <select id="" class="form-control" name="account_type">
                @if ($user->hasRole('administrator'))
                    <option>Admin</option>
                    <option>Staff</option>
                @else
                    <option>Staff</option>
                    <option>Admin</option>
                @endif
            </select>
            </div>
            <div class="form-group file-name">
                <label for="country_name">New Password</label>
                <input type="text" class="form-control" name="password" value=""/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="far fa-edit"></i> Update</button>
            </div>  
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/user.js') }}"></script>
@endpush