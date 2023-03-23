<div id="mySidenav" class="sidenav">
        <div class="sideBarLogo">
          <a href="{{ url('/') }}" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'index.php') ? ' active' : '');?>">
            <img src="{{ asset('build/images/site_logos/'.$site->site_logo )}}" alt="">
          </a>
        </div>
        <ul>
          <li>
            <a href="index.php">Home</a></li>
          <li>
            <a href="categories.php">Categories</a>
          </li>
          </li>
        </ul>
      </div>
      <header class="header">
        <div class="Top">
          <div class="flexWrapper">
            <span class="menu" onclick="openNav()">
              <i class="lm_menu"></i>
            </span>
            <a href="{{ url('/') }}">
              <img src="{{ asset('build/images/site_logos/'.$site->site_logo )}}" alt="">
            </a>
            <span class="searchRes">
              <i class="lm_search"></i>
            </span>
          </div>
        </div>
       @if(isset($site_menu) && !empty($site_menu))
        <nav class="links">
          <div class="flexWrapper">
            @foreach($site_menu as $key=>$value)
            <a href="{{ $value }}">{{ $key }}</a>
            @endforeach
          </div>
        </nav>
       @endif
      </header>