<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Sewa Buku</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @if (Auth::check() && Auth::user())
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('buku.index') }}">Buku</a>
        </li>
        @endif 
        @if (Auth::check() && Auth::user()->level == 'admin')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('peminjam.index') }}">Peminjam</a>
        </li>
        @endif 
        @if (Auth::check() && Auth::user()->level == 'admin')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('transaksi_peminjaman.index') }}">Transaksi Peminjaman</a>
        </li>
        @endif 
        @if (Auth::check() && Auth::user()->level == 'admin')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.index') }}">User</a>
        </li>
        @endif 
        @if (Auth::check() && Auth::user())
        <li class="nav-item">
          <a class="btn btn-danger btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
        @endif 
        </ul>
        <div>
          @if (Auth::check())
            <b>{{ 'Halo, '. Auth::user()->name }}</b>
          @else
          @endif
        </div>
    </div>
  </div>
</nav>
