@foreach($folders as $folder)
<tr class='table-row' data-href="{{ route('folder.show', $folder->id) }}">
    <td class='table-data d-flex align-items-center' data-href="{{ route('folder.show', $folder->id) }}">
        <i class="fas fa-folder icon table-preview"></i>
        <a class="m-2">{{ $folder->name }}</a>
    </td>
    <td></td>
    <td></td>
    <td>{{ $folder->created_at->format('M j, Y h:i:s A') }}</td>
    <td>
        @role('administrator')
        <div class="dropdown">
            <button class="btn btn-light table-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('folder.edit', $folder->id) }}"><i class="far fa-edit"></i> View/Edit</a>
                <form action="{{ route('folder.destroy', $folder->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="dropdown-item btn btn-light" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
        @endrole
    </td>
</tr>
@endforeach

@foreach($files as $file)
<tr class='table-row' >
    @if (strpos($file->mime_type, 'audio') !== false)
    <td class='d-flex align-items-center table-file' data-id="{{ $file->id }}" data-name="{{ $file->name }}" data-src='{{ asset($file->file_path) }}' data-mime='{{ $file->mime_type }}' data-type='audio'>
        <audio id="audo-file" class="table-preview" controls>
            <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
        </audio>
    @elseif (strpos($file->mime_type, 'video') !== false)
    <td class='d-flex align-items-center table-file' data-id="{{ $file->id }}" data-name="{{ $file->name }}" data-src='{{ asset($file->file_path) }}' data-mime='{{ $file->mime_type }}' data-type='video'>
        <i class="fas fa-play-circle table-preview"></i>
        {{-- <i class="fab fa-youtube table-preview"></i> --}}
        {{-- <img class="table-preview" src="{{ asset($file->thumbnail_path) }}" alt=""> --}}
    @elseif (strpos($file->mime_type, 'image') !== false)
    <td class='d-flex align-items-center table-file' data-id="{{ $file->id }}" data-name="{{ $file->name }}" data-src='{{ asset($file->file_path) }}' data-mime='{{ $file->mime_type }}' data-type='image'>
        <img class="table-preview" src="{{ asset($file->file_path) }}" alt="">
    @else
    <td class='d-flex align-items-center table-file' data-id="{{ $file->id }}" data-name="{{ $file->name }}" data-src='{{ asset($file->file_path) }}' data-mime='{{ $file->mime_type }}' data-type='others'>
        <i class="far fa-file table-preview icon"></i>
    @endif
        <a class="m-2" class="file-name">{{ $file->name }}</a>
    </td>
    <td>
        @foreach ($file->tags as $tag)
        <div class="bg-secondary mb-2 d-inline-block tags">
            <code class="h6 text-light p-1 m-0">{{ $tag->name }}</code>
        </div>
        @endforeach

    </td>
    <td>{{ $file->file_size }}</td>
    <td>{{ $file->created_at->format('M j, Y h:i:s A') }}</td>
    <td>
        @role('administrator')
        <div class="dropdown">
            <button class="btn btn-light table-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ asset($file->file_path) }}" download><i class="fas fa-download"></i> Download</a>
                {{-- @role('administrator') --}}
                    <a class="dropdown-item" href="{{ route('file.edit', $file->id) }}"><i class="far fa-edit"></i> View/Edit</a>
                    <form action="{{ route('file.destroy', $file->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="dropdown-item btn btn-light" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                    </form>
                {{-- @endrole --}}
            </div>
        </div>
        @endrole
    </td>
</tr>
@endforeach

<div class="modal fade lightbox mt-10 mt-md-0" id="lightbox" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}
            <div class="modal-body">
                <div class="body">loading...</div>
            </div>
        </div>
    </div>
</div>