<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('home') }}">Home</a></li>
        @if ($folder->parent)
            @if ($folder->parent->parent)
                @include('folder.breadcrumbs-parent', ['folder' => $folder->parent])
            @endif
            <li class="breadcrumb-item"><a href="{{ route('folder.show', $folder->parent->id) }}">{{ $folder->parent->name }}</a></li>
        @endif
        <li class="breadcrumb-item active">
            {{ $folder->name }}
        </li>
    </ol>
</nav>