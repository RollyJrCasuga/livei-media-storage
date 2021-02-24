@extends('layout')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
        </ol>
    </nav>
    <div class="col-md-6">
        <a class="btn btn-success" href="{{ route('user.create') }}">+ Add User</a>
    </div>
    <div class="table-responsive mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="table-header" data-id="name">First Name</th>
                    <th scope="col" class="table-header" data-id="name">Last Name</th>
                    <th scope="col" class="table-header" data-id="name">Email</th>
                    <th scope="col" class="table-header" data-id="date">Date Created</th>
                    <th scope="col" class="table-header" data-id="date">Option</th>
                </tr>
            </thead>
            <tbody id="table-content">
                @include('user.table')
            </tbody>
        </table>
    </div>
@endsection
@push('scripts')
<script src="{{ asset('js/user.js') }}"></script>
@endpush