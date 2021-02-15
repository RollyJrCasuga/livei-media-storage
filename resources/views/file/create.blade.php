@extends('layout')

@section('content')

<div class="create d-flex justify-content-center">
    <div class="card">
    <div class="card-header">
    <a class="btn btn-light mb-2" href="{{ route('file.index') }}"><i class="fas fa-arrow-left"></i></a>
    <h4>New File Upload</h4>
    </div>
    <div class="card-body">
        <form id="upload-form" method="POST" action="{{ route('file.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div class="d-flex justify-content-center">
                    {{-- <input class="file-upload" type="file" name="file" required> --}}
                    <input class="file-upload" type="file" name="files[]" multiple>
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
            <div class="form-group">
                <div class="progress">
                    <div class="bar"></div >
                    <div class="percent">0%</div >
                </div>
            </div>
            <input type="submit"  value="Submit" class="btn btn-primary">
        </form>
    </div>
</div>
</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script>
    var SITEURL = "{{URL('/')}}";
    var bar = $('.bar');
    var percent = $('.percent');
    $('#upload-form').ajaxForm({
        beforeSend: function () {
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        complete: function (xhr) {
            window.location.href = SITEURL + "/file";
        }
    });
    
    var tagsWhiteList = [@foreach ($tags as $tag)"{{$tag->name}}"@if(!$loop->last), @endif @endforeach];
</script>
<script src="{{ asset('js/file.js') }}"></script>
@endpush