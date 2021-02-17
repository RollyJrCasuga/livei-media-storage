@foreach($folders as $folder)
<tr class='table-data table-row' data-href="{{ route('folder.show', $folder->id) }}">
    <td class=' d-flex align-items-center'  >
        <i class="far fa-folder table-preview"></i>
        <a class="m-2">{{ $folder->name }}</a>
    </td>
    <td></td>
    <td></td>
    <td>{{ $folder->created_at->format('M j, Y h:i:s A') }}</td>
</tr>
@endforeach

@foreach($files as $file)
<tr class='table-data table-row' data-href="{{ route('file.edit', $file->id) }}">
    <td class=' d-flex align-items-center'  >
        @if (strpos($file->mime_type, 'audio')  !== false )
            <audio class="table-preview" controls>
                <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
            </audio>
        @elseif (strpos($file->mime_type, 'video')  !== false )
            {{-- <img class="table-preview" src="{{ asset($file->file_path) }}" alt=""> --}}
            <i class="fas fa-play-circle table-preview"></i>
        @elseif (strpos($file->mime_type, 'image')  !== false )
            <img class="table-preview" src="{{ asset($file->file_path) }}" alt="">
        @else
            <i class="far fa-file table-preview"></i>
        @endif
        <a class="m-2">{{ $file->name }}</a>
    </td>
    <td>
        @foreach ($file->tags as $tag)
        <div class="bg-secondary mb-2 d-inline-block">
            <code class="h6 text-light p-1 m-0">{{ $tag->name }}</code>
        </div>
        @endforeach
        
    </td>
    <td>{{ $file->file_size }}</td>
    <td>{{ $file->created_at->format('M j, Y h:i:s A') }}</td>
</tr>
@endforeach