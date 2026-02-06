<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
 

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
        <i class="fas fa-user"></i> {{ Auth::user()->name ?? " " }}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right show nav-item dropdown" style="left: inherit; right: 0px; ">
            <div class="dropdown-divider"></div>
              <a href="{{route('profile.edit')}}" class="dropdown-item">
            <i class="fas fa-user"></i> profile
          
          </a>
            <a href="{{ route('logout') }}" class="dropdown-item"
                 onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
            </a>
          
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        
      </li>
   
    </ul>
  </nav>