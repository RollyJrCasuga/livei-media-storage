@foreach($users as $user)
<tr class='table-row' data-href="{{ route('folder.show', $user->id) }}">
    <td class='d-flex align-items-center'><a class="m-2">{{ $user->first_name }}</a></td>
    <td><a class="m-2">{{ $user->last_name }}</a></td>
    <td><a class="m-2">{{ $user->email }}</a></td>
    <td>{{ $user->created_at->format('M j, Y h:i:s A') }}</td>
    <td>
        <div class="dropdown">
            <button class="btn btn-light table-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('user.show', $user->id) }}"><i class="far fa-edit"></i> Edit</a>
                <form action="{{ route('user.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="dropdown-item btn btn-light" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
    </td>
</tr>
@endforeach
