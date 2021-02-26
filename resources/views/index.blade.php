@extends('layout')
@section('content')

<div id="home" class="home">
    <div class="row mt-3">
        <div class="col-md-6">
            <input class="" name="tags-select-mode" id="search" class="search" type="text" placeholder="Search tags">
        </div>
        <div class="col-md-6 row mt-3 mt-md-0 home-btn">
            <div class="col-6 pl-0">
                <div class="dropdown">
                <button class="btn btn-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <div class="col-6 pr-0">
                <div class="dropdown">
                @role('administrator')
                <button class="btn btn-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-file-import"></i>  Import/Export
                </button>
                @endrole
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('file.import') }}">Import Data</a>
                    <a class="dropdown-item" href="{{ route('file.export') }}">Export Data</a>
                </div>
                </div>
            </div>
        </div>
    </div>
     @include('partials.breadcrumbs')
    <div class="d-flex justify-content-center">
        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="table-header" data-id="name" data-sort_type="asc">Name</th>
                    <th scope="col" class="table-header" data-id="tags" data-sort_type="asc"><i class="fas fa-tags"></i> Tags</th>
                    <th scope="col" class="table-header" data-id="size" data-sort_type="asc">File Size</th>
                    <th scope="col" class="table-header" data-id="date" data-sort_type="asc">Date Uploaded</th>
                    @role('administrator')
                    <th scope="col" class="table-header" data-id="" data-sort_type="asc">Option</th>
                    @endrole
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
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/search.js') }}"></script>
@endpush