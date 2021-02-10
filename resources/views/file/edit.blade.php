@extends('layout')

@section('content')
<div class="d-flex justify-content-center">
  <div class="card">
  <div class="card-header">
    <h3>
      {{ $file->name }}
    </h3>
  </div>
  <div class="card-body">
      @if (strpos($file->mime_type, 'audio')  !== false )
          <audio class="media-view" controls>
              <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
          </audio>
      @elseif (strpos($file->mime_type, 'video')  !== false )
          <video class="media-view" controls>
              <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
          </video>
      @elseif (strpos($file->mime_type, 'image')  !== false )
          <img class="media-view" src="{{ asset($file->file_path) }}" alt="">
      @else
          <img>
      @endif

      <form method="post" action="{{ route('file.update', $file->id) }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
              @method('PATCH')
              <label for="country_name">New File Name:</label>
              <input type="text" class="form-control" name="name" value="{{ $file->name }}"/>
          </div>
          <div class="form-group">
                <label for="">Tags:</label>
                <input id="tags" type="text" name="tags" class="tagify--outside" value="@foreach ($file->tags as $tag){{$tag->name}}@if(!$loop->last), @endif @endforeach">
                <button class="mt-3 btn btn-danger tags--removeAllBtn" type="button">Remove all tags</button>
            </div>
          <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>

@endsection
@push('scripts')
<script>
    var tagsWhiteList = [@foreach ($tags as $tag)"{{$tag->name}}"@if(!$loop->last), @endif @endforeach];
</script>
<script src="{{ asset('js/file.js') }}"></script>
@endpush