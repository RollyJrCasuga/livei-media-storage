@extends('layout')

@section('content')
<br>
<div id="home" class="home">
    <div class="row">
        <div class="col-md-3">
            {{-- <a class="btn btn-success" href="{{ route('file.create') }}"><i class="fas fa-plus"></i> New Upload</a> --}}
            <div class="dropdown">
            <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-plus"></i> New
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('file.create') }}">File Upload</a>
                @if($folder)
                <a class="dropdown-item" href="{{ route('folder.create',['folder_path'=>$folder->folder_path]) }}">Folder</a>
                @else
                    <a class="dropdown-item" href="{{ route('folder.create') }}">Folder</a>
                @endif
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <input class="" name="tags-select-mode" id="search" class="search" type="text" placeholder="Search tags">
            {{-- <input class="" id="search" class="search" type="text" placeholder="Search tags"> --}}
        </div>
        <div class="col-md-2">
            <a class="export-btn btn btn-info" href="{{ route('file.import') }}"><i class="fas fa-file-import"></i> Import</a>
        </div>
        <div class="col-md-2">
            <a class="export-btn btn btn-info" href="{{ route('file.export') }}"><i class="fas fa-file-export"></i> Export</a>
        </div>
    </div>
    <br>

     @include('partials.breadcrumbs')

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="table-header" data-id="name" data-sort_type="asc">Name</th>
                    <th scope="col" class="table-header" data-id="tags" data-sort_type="asc"><i class="fas fa-tags"></i> Tags</th>
                    <th scope="col" class="table-header" data-id="size" data-sort_type="asc">File Size</th>
                    <th scope="col" class="table-header" data-id="date" data-sort_type="asc">Date Uploaded</th>
                </tr>
            </thead>
            <tbody id="table-content">
                @include('file.table')
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $files->links() }}
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/search.js') }}"></script>
@endpush