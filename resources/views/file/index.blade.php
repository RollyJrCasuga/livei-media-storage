@extends('layout')

@section('content')
<div id="home" class="home">
    <form action="/logout" method="POST">
        @csrf
        <button class="btn btn-light" type="submit">Logout</button>
    </form>
<br>
<h2><i class="fas fa-database"></i> Drive - Livei.com</h2>
    <div class="row">
        <div class="col-md-4">
            <a class="btn btn-success" href="{{ route('file.create') }}"><i class="fas fa-plus"></i> New Upload</a>
        </div>
        <div class="col-md-4">
            <input class="" id="search" class="search" type="text" placeholder="Search tags">
        </div>
        <div class="col-md-4">
            <a class="export-btn btn btn-info" href="{{ route('file.export') }}"><i class="fas fa-file-export"></i> Export</a>
        </div>
    {{-- <input name='tags-select-mode' class='selectMode' placeholder="Please select" /> --}}
    </div>
    <br>
    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col"><i class="fas fa-tags"></i> Tags</th>
                <th scope="col">File Size</th>
                <th scope="col">Date Uploaded</th>
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
<script>
    var tagsWhiteList = [];
</script>
<script src="{{ asset('js/file.js') }}"></script>
@endpush