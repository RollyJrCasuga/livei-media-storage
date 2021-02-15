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
    <td class="">
        @foreach ($file->tags as $tag)
            <code class="bg-secondary h6 text-light p-1">{{ $tag->name }}</code>
        @endforeach
        
    </td>
    <td>{{ $file->file_size }}</td>
    <td>{{ $file->created_at->format('M j, Y h:i:s A') }}</td>
</tr>
@endforeach