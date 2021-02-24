@if(session('message'))
<div class="flash-message">
    @if (is_array(session('message')))
        @foreach (session('message') as $message)
        <p id="alert" class="alert alert-{{ session('alert-class', 'info') }}">
            <a href="#" class="ml-3 close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $message }}
        </p>
        @endforeach
    @else
    <p id="alert" class="alert alert-{{ session('alert-class', 'info') }}">
        <a href="#" class="ml-3 close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('message') }}
    </p>
    @endif
</div>
@endif