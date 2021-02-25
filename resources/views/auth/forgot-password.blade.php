@extends('layout')

@section('content')

<div class="login align-items-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-center login-header">
                    <img src="/images/liveicom.png" alt="">
                    <h1>Drive</h1>
                </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
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
                        @if (session('status'))
                            <p class="alert alert-success">{{ session('status') }}</p>
                        @endif
                        <div class="form-group row mt-2">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-4 mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success text-light forgot-password-btn">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
<script>

</script>
<script src="{{ asset('js/auth.js') }}"></script>
@endpush