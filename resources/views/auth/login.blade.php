@extends('layout')

@section('content')

<div class="card w-60">
    <div class="card-header">
    <h1>Drive - Livei.com</h1>
    </div>
    <div class="card-body">
        <form method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">User:</label>
                <input type="text" class="form-control" name="name"/>
            </div>
            <div class="form-group">
                <label for="">Password:</label>
                <input type="password" class="form-control" name="password"/>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>

</script>
<script src="{{ asset('js/files.js') }}"></script>
@endpush