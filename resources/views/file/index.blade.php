@extends('layout')

@section('content')
<div class="home">
<br>
<h2>Drive - Livei.com</h2>
<br>
    <div class="row">
        <div class="col-md-4">
            <a class="btn btn-success" href="{{ route('file.create') }}"><i class="fas fa-plus"></i> New Upload</a>
        </div>
        <div class="col-md-4">
            <input class="" id="search" class="search" type="text" placeholder="Search">
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
                <th scope="col">Tags</th>
                <th scope="col">File Size</th>
                <th scope="col">Date Uploaded</th>
                {{-- <th scope="col">Option</th> --}}
            </tr>
        </thead>
        <tbody id="table-content">
            @include('file.table')
            {{-- @foreach($files as $file)
            <tr class='table-row'>
                <td class='table-data d-flex align-items-center' data-href="{{ route('file.edit', $file->id) }}" >
                    @if (strpos($file->mime_type, 'audio')  !== false )
                        <audio class="table-preview" controls>
                            <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
                        </audio>
                    @elseif (strpos($file->mime_type, 'video')  !== false )
                        <i class="fas fa-play-circle table-preview"></i>
                    @elseif (strpos($file->mime_type, 'image')  !== false )
                        <img class="table-preview" src="{{ asset($file->file_path) }}" alt="">
                    @else
                        <i class="far fa-file table-preview"></i>
                    @endif
                    <a class="m-2">{{ $file->name }}</a>
                </td>
                <td class="">
                    @foreach ($file->tags as $tag)
                        <code class="bg-secondary h6 text-light p-1">{{ $tag->name }}</code>
                    @endforeach
                    
                </td>
                <td>{{ $file->file_size }}</td>
                <td>{{ $file->created_at->format('M j, Y h:i:s A') }}</td>
            </tr>
            @endforeach --}}
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