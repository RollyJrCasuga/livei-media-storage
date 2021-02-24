@extends('layout')
@section('content')
<div id="home" class="home">
    <div class="row">
        <div class="col-md-3">
            <a class="btn btn-success" href="{{ route('file.create') }}"><i class="fas fa-plus"></i> New Upload</a>
        </div>
        <div class="col-md-3">
            <input class="" id="search" class="search" type="text" placeholder="Search tags">
        </div>
        <div class="col-md-3">
            <a class="export-btn btn btn-info" href="{{ route('file.export') }}"><i class="fas fa-file-export"></i> Export</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th scope="col" class="table-header" data-id="name">Name</th>
                <th scope="col" class="table-header" data-id="tags"><i class="fas fa-tags"></i> Tags</th>
                <th scope="col" class="table-header" data-id="size">File Size</th>
                <th scope="col" class="table-header" data-id="date">Date Uploaded</th>
                @role('administrator')
                <th scope="col" class="table-header" data-id="date">Option</th>
                @endrole
            </tr>
        </thead>
        <tbody id="table-content">
            @include('file.table')
        </tbody>
    </table>
    </div>
    <div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/file.js') }}"></script>
@endpush