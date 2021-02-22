@foreach($folders as $folder)
<tr class='table-row' data-href="{{ route('folder.show', $folder->id) }}">
    <td class='table-data d-flex align-items-center' data-href="{{ route('folder.show', $folder->id) }}">
        <i class="far fa-folder table-preview"></i>
        <a class="m-2">{{ $folder->name }}</a>
    </td>
    <td></td>
    <td></td>
    <td>{{ $folder->created_at->format('M j, Y h:i:s A') }}</td>
    <td>
        <div class="dropdown">
            <button class="btn btn-light table-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <form action="{{ route('folder.destroy', $folder->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="dropdown-item btn btn-light" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
    </td>
</tr>
@endforeach

@foreach($files as $file)
<tr class='table-row' >
    <td class='table-data d-flex align-items-center' data-href="{{ route('file.edit', $file->id) }}">
        @if (strpos($file->mime_type, 'audio')  !== false )
            <audio class="table-preview" controls>
                <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
            </audio>
        @elseif (strpos($file->mime_type, 'video')  !== false )
            <i class="fas fa-play-circle table-preview"></i>
        @elseif (strpos($file->mime_type, 'image')  !== false )
            <img class="table-preview" src="{{ asset($file->file_path) }}" alt="">
        @else
            <i class="far fa-file table-preview"></i>
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
        <div class="dropdown">
            
            <button class="btn btn-light table-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <form action="{{ route('file.destroy', $file->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="dropdown-item btn btn-light" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
    </td>
</tr>
@endforeach
