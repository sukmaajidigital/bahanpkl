<nav class="navbar navbar-expand-lg main-navbar bg-primary">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      </ul>
    </form>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}"
          onclick="event.preventDefault();
                      document.getElementById('logout_id').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
          <form method="POST" id="logout_id" action="{{ route('logout') }}" style="display:none;">
            @csrf

        </form>
        </div>
      </li>
    </ul>
  </nav>
