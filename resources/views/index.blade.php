@extends('layout')

@section('content')
<div id="home" class="home">
    <div class="row">
        <div class="col-md-2">
            <a class="btn btn-success" href="{{ route('file.create') }}"><i class="fas fa-plus"></i> New Upload</a>
        </div>
        <div class="col-md-2">
            @if($folder)
                <a class="btn btn-success" href="{{ route('folder.create',['folder_path'=>$folder->folder_path]) }}"><i class="fas fa-plus"></i> New Folder</a>
            @else
                <a class="btn btn-success" href="{{ route('folder.create') }}"><i class="fas fa-plus"></i> New Folder</a>
            @endif
        </div>
        <div class="col-md-3">
            <input class="" name="tags-select-mode" id="search" class="search" type="text" placeholder="Search tags">
            {{-- <input class="" id="search" class="search" type="text" placeholder="Search tags"> --}}
        </div>
        <div class="col-md-2">
            <a class="export-btn btn btn-info" href="{{ route('file.export') }}"><i class="fas fa-file-export"></i> Import</a>
        </div>
        <div class="col-md-2">
            <a class="export-btn btn btn-info" href="{{ route('file.export') }}"><i class="fas fa-file-export"></i> Export</a>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th scope="col" class="table-header" data-id="name">Name</th>
                <th scope="col" class="table-header" data-id="tags"><i class="fas fa-tags"></i> Tags</th>
                <th scope="col" class="table-header" data-id="size">File Size</th>
                <th scope="col" class="table-header" data-id="date">Date Uploaded</th>
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
<script src="{{ asset('js/search.js') }}"></script>
@endpush