@extends('layout')

@section('content')
<br>
<h2>Drive - Livei.com</h2>
<br>
<div>
    <a class="btn btn-success" href="{{ route('file.create') }}">+ New Upload</a>
    {{-- <input type="text" placeholder="Search"> --}}
</div>
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
    <tbody>
        @foreach($files as $file)
        <tr class='table-row'>
            <td class='table-data' data-href="{{ route('file.edit', $file->id) }}" >
                @if (strpos($file->mime_type, 'audio')  !== false )
                    <audio class="table-preview" controls>
                        <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
                    </audio>
                @elseif (strpos($file->mime_type, 'video')  !== false )
                    {{-- <img class="table-preview" src="{{ asset($file->file_path) }}" alt=""> --}}
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
            {{-- <td>
                <form action="{{ route('file.destroy', $file->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td> --}}
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
  

<div>
@endsection

@push('scripts')
<script>
    var tagsWhiteList = [];
</script>
<script src="{{ asset('js/file.js') }}"></script>
@endpush