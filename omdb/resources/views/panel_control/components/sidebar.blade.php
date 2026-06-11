      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">OMDB Nadira</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">OZ</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">{{__('messages.pages') }}</li>
            <li class="dropdown active">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-film"></i><span>{{__('messages.movies') }}</span></a>
              <ul class="dropdown-menu">
                <li  class="{{ Route::is('dashboard*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}">{{__('messages.search_movies') }}</a></li>
                <li  class="{{ Route::is('favorites*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('favorites.index') }}">{{__('messages.favorite_movies') }}</a></li>
              </ul>
            </li>
      </div>