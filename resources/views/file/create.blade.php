@extends('layout')

@section('content')

<div class="create d-flex justify-content-center">
    <div class="card">
    <div class="card-header">
    <a class="btn btn-light mb-2" href="{{ route('file.index') }}"><i class="fas fa-arrow-left"></i></a>
    <h4>New File Upload</h4>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('file.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div class="d-flex justify-content-center">
                    <input class="file-upload" type="file" name="file" required>
                </div>
            </div>
            <div class="form-group">
                <label for="">Name:</label>
                <input type="text" class="form-control" name="name"/>
            </div>
            <div class="form-group">
                <label for="">Tags:</label>
                <input id="tags" type="text" name="tags" class="tagify--outside">
                <button class="mt-3 btn btn-danger tags--removeAllBtn" type="button"><i class="fas fa-tags"></i> Remove all tags</button>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
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