@extends('layout')
@section('content')
    <div class="create d-flex justify-content-center card-wrapper">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-light mb-2" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                <h4>Select file (.xlsx)</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('file.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                        <div class="custom-file text-left">
                            <input type="file" name="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <button class="btn btn-primary">Import data</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush