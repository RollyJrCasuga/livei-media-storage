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
                    @if ($folder)
                        <a class="dropdown-item" href="{{ route('file.create',['folder_id'=>$folder->id]) }}">File Upload</a>
                    @else
                        <a class="dropdown-item" href="{{ route('file.create') }}">File Upload</a>
                    @endif
                    @if($folder)
                        <a class="dropdown-item" href="{{ route('folder.create',['folder_id'=>$folder->id]) }}">Folder</a>
                    @else
                        <a class="dropdown-item" href="{{ route('folder.create') }}">Folder</a>
                    @endif
                </div>
                </div>
            </div>
            
        </div>
    </div>

    @include('folder.breadcrumbs', ['folder'=>$folder])
    
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