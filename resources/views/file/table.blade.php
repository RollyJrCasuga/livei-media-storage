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
        @role('administrator')
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
        @endrole
    </td>
</tr>
@endforeach

@foreach($files as $file)
<tr class='table-row' >
    {{-- <td data-toggle="modal" data-target="#lightbox-{{ $file->id }}" class='d-flex align-items-center' data-href="{{ route('file.edit', $file->id) }}"> --}}
    {{-- <td class='d-flex align-items-center' data-href="{{ route('file.edit', $file->id) }}">
        @if (strpos($file->mime_type, 'audio')  !== false )
            <audio id="audo-file" class="table-preview" controls>
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
    </td> --}}
    @if (strpos($file->mime_type, 'audio')  !== false )
        <td class='d-flex align-items-center table-file' data-name="{{ $file->name }}" data-src='{{ asset($file->file_path) }}' data-mime='{{ $file->mime_type }}' data-type='audio'>
            <audio id="audo-file" class="table-preview" controls>
                <source src="{{ asset($file->file_path) }}" type="{{ $file->mime_type }}">
            </audio>
            
    @elseif (strpos($file->mime_type, 'video')  !== false )
        <td class='d-flex align-items-center table-file' data-name="{{ $file->name }}" data-src='{{ asset($file->file_path) }}' data-mime='{{ $file->mime_type }}' data-type='video'>
            <i class="fas fa-play-circle table-preview"></i>

    @elseif (strpos($file->mime_type, 'image')  !== false )
        <td class='d-flex align-items-center table-file' data-name="{{ $file->name }}" data-src='{{ asset($file->file_path) }}' data-mime='{{ $file->mime_type }}' data-type='image'>
            <img class="table-preview" src="{{ asset($file->file_path) }}" alt="">

    @else
        <td class='d-flex align-items-center table-file' data-name="{{ $file->name }}" data-src='{{ asset($file->file_path) }}' data-mime='{{ $file->mime_type }}' data-type='others'>
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
        @role('administrator')
        <div class="dropdown">
            <button class="btn btn-light table-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('file.edit', $file->id) }}"><i class="far fa-edit"></i> View/Edit</a>
                <a class="dropdown-item" href="{{ asset($file->file_path) }}" download><i class="fas fa-download"></i> Download</a>
                <form action="{{ route('file.destroy', $file->id) }}" method="post">
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

<div class="modal fade lightbox mt-10 mt-md-0" id="lightbox" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="body">loading...</p>
      </div>
    </div>
  </div>
</div>