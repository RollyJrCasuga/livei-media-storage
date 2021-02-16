@extends('layout')

@section('content')
<div class="create d-flex justify-content-center">
    <div class="card">
    <div class="card-header">
    <a class="btn btn-light mb-2" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i></a>
    <h4>New Folder</h4>
    </div>
    <div class="card-body">
        <form id="upload-form" method="POST" action="{{ route('file.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Name:</label>
                <input type="text" class="form-control" name="name"/>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create</button>
        </form>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
    
</script>
@endpush