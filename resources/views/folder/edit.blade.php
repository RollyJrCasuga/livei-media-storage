@extends('layout')

@section('content')
<div class="create d-flex justify-content-center card-wrapper">
    <div class="card">
    <div class="card-header">
    <a class="btn btn-light mb-2" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
    <h4>Rename Folder</h4>
    </div>
    <div class="card-body">
        <form id="upload-form" method="POST" action="{{ route('folder.update', $folder->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="">Name:</label>
                <input type="text" class="form-control" name="name" value={{$folder->name}}/>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Update</button>
        </form>
    </div>
</div>
</div>
@endsection
