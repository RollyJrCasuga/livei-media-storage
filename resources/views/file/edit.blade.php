@extends('layout')

@push('styles')
<link href="{{ asset('css/view.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="view d-flex justify-content-center">
  <div class="card">
    <div class="card-header">
        <a class="btn btn-light mb-2" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
        <a class="ml-2  ">
        {{ $file->name }}
        </a>
    </div>
    <div class="card-body">
        @if (strpos($file->mime_type, 'audio')  !== false )
            <audio class="media-view" controls>
                <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
            </audio>
        @elseif (strpos($file->mime_type, 'video')  !== false )
            <video
                id="my-video"
                class="video-js media-view"
                controls
                preload="auto"
                data-setup="{}"
            >
                <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}" />
            </video>

        @elseif (strpos($file->mime_type, 'image')  !== false )   
            <img class="media-view" src="{{ asset($file->file_path) }}" alt="">
        @endif
            <form class="mt-3" method="post" action="{{ route('file.update', $file->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group file-name">
                    @method('PATCH')
                    <label for="country_name">New File Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ $file->name }}"/>
                </div>
                <div class="form-group">
                    <label for="">Tags:</label>
                    <input id="tags" type="text" name="tags" class="tagify--outside" value="@foreach ($file->tags as $tag){{$tag->name}}@if(!$loop->last), @endif @endforeach">
                    <button class="mt-3 btn btn-danger tags--removeAllBtn" type="button"><i class="fas fa-tags"></i> Remove all tags</button>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="far fa-edit"></i> Update</button>
                </div>
            </form>
                <div class="form-group">
                    <a class="btn btn-success" href="{{ asset($file->file_path) }}" download><i class="fas fa-download"></i> Download</a>
                </div>
                @role('administrator')
                    <div class="form-group">
                        <form action="{{ route('file.destroy', $file->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                        </form>
                    </div>
                @endrole
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/file.js') }}"></script>
@endpush