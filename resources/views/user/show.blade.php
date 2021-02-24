@extends('layout')

@section('content')
<div class="view d-flex justify-content-center mt-5">
  <div class="card">
    <div class="card-header">
        <a class="btn btn-light mb-2" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
        <a class="ml-2  ">
        </a>
    </div>
    <div class="card-body pt-1 pt-md-0">        
        <form class="mt-3" method="post" action="{{ route('file.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group file-name">
                <label for="country_name">First Name:</label>
                <input type="text" class="form-control" name="first_" value="{{ $user->first_name }}"/>
            </div>
            <div class="form-group file-name">
                <label for="country_name">Last Name:</label>
                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}"/>
            </div>
            <select id="" class="form-control" name="account_type">
                <option selected></option>
                <option>Admin</option>
                <option>Staff</option>
            </select>
            <div class="form-group file-name">
                <label for="country_name">Password</label>
                <input type="text" class="form-control" name="password" value="{{ $user->password }}"/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="far fa-edit"></i> Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/user.js') }}"></script>
@endpush