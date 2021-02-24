<nav class="navbar navbar-expand-lg navbar-light bg-white custom-navbar">
    <a class="navbar-brand" href="{{ route('home') }}">
      <i class="fas fa-database"></i> Drive - Livei.com
    </a>
  {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> --}}

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>
  </div>
  <ul>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle pr-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ auth()->user()->first_name }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @role('administrator')
                <a class="dropdown-item" href="/user">Manage Users</a>
            @endrole
            <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
            </a>
            <form id="logout-form" action="/logout" method="POST" class="d-none">
                @csrf
            </form>
        </div>
      </li>
    </ul>
</nav>