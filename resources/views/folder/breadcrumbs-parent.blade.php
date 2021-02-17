@if ($folder->parent->parent)
    @include('folder.breadcrumbs-parent', ['folder' => $folder->parent])
@endif
<li class="breadcrumb-item"><a href="{{ route('folder.show', $folder->parent->id) }}">{{ $folder->parent->name }}</a></li>