<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      {{-- <h1 class="logo me-auto"><a href="index.html">Wardan Tech Ltd</a></h1> --}}
      <!-- Uncomment below if you prefer to use an image logo -->
      <?php
        $generalSettings = App\Models\Admin\Settings\GeneralSetting::first();
      ?>
      <a href="#" class="logo me-auto"><img src="@isset($generalSettings) {{ asset('img/' . $generalSettings->favicon) }} @endisset" alt="" class="img-fluid"></a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li><a class="nav-link scrollto" href="#team">Team</a></li>
          <li><a class="nav-link scrollto" href="#packages">Packages</a></li>
          <li><a class="nav-link scrollto" href="#faq">FAQ</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a class="nav-link scrollto" href="{{ url('dashboard') }}"> @if(Auth::user()) {{ Auth::user()->name }}@else Login @endif </a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <!-- .navbar -->
    </div>
  </header>
