<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ route('blog.index') }}">Laravel Guide</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

      <li class="nav-item active">
        <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('other.about') }}">About</a>
      </li>

      
      @if(Auth::check())
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.index') }}">Posts</a>
      </li>
      @endif
    </ul>
</div>

<div class="nav navbar-nav my-2 my-lg-0">

  @if(!Auth::check())
  <li class="nav-item">
      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
  </li>

  @else
  <li class="nav-item dropdown">
      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->name }}
      </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('user.profile') }}"
              onclick="event.preventDefault();
                            document.getElementById('profile-form').submit();">
              {{ __('Profile') }}
          </a>
          <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
      </div>
  </li>
  @endif
 
</div>

    
</nav>