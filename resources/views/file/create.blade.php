@extends('layout')
@section('content')
<div class="create d-flex justify-content-center card-wrapper">
    <div class="card">
        <div class="card-header">
            <a class="btn btn-light mb-2" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
            <h4>New File Upload</h4>
        </div>
        <div class="card-body">
            <form id="upload-form" class="mt-3" method="POST" action="{{ route('file.store') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if ($folder_id)
                    <input type="hidden" name="folder_id" value="{{ $folder_id }}"/>
                @endif
                <div class="form-group">
                    <div class="d-flex flex-column justify-content-center">
                        <span id="file-chosen">No file chosen</span>
                        <input id="file-upload-btn" class="file-upload" type="file" name="files[]" multiple hidden>
                        <label class="btn btn-success" for="file-upload-btn">Select file</label>
                    </div>
                </div>
                <div class="form-group file-name">
                    <label for="">Name:</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="">Tags:</label>
                    <input id="tags" type="text" name="tags" class="tagify--outside">
                    <button class="mt-3 btn btn-light tags--removeAllBtn" type="button"><i class="fas fa-tags"></i> Remove all tags</button>
                </div>
                <div class="form-group">
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>
                </div>
                <div id="loading-div" class="d-flex justify-content-center">
                    {{-- <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><a class="ml-2">Uploading...</a> --}}
                </div>
                <input id="upload-btn" type="submit"  value="+ Upload" class="btn btn-primary mt-3">
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
            $( "#upload-btn" ).prop( "disabled", true );
            $( "#loading-div" ).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><a class="ml-2">Uploading...</a>');
        },
        complete: function (xhr) {
            // console.log(xhr.responseJSON);
            window.location.href = xhr.responseJSON.url;
            // window.location.reload();
        }
    });
</script>
<script src="{{ asset('js/file.js') }}"></script>
@endpush