<?php
    $generalSettings = App\Models\Admin\Settings\GeneralSetting::first();
    $socialLink = App\Models\FrontEnd\SocialMediaSetting::first();
    $serviceSetting = App\Models\FrontEnd\ServiceSetting::where('status', 1)->limit(4)->get();
?>
<footer id="footer">
    <div class="footer-top" style="background-color: #faf9f9">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>{{ isset($generalSettings) ?$generalSettings->name : ''}}</h4>
            <p>
                {{ isset($generalSettings) ? $generalSettings->address : ''}} <br><br>
              <strong>Phone:</strong> {{ isset($generalSettings) ? $generalSettings->phone : ''}}<br>
              <strong>Email:</strong> {{ isset($generalSettings) ? $generalSettings->email : ''}}<br>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#packages">Packages</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
                @foreach ($serviceSetting as $service)
                  <li><i class="bx bx-chevron-right"></i><a href="#services">{{ $service->title }}</a></li>
                @endforeach
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Social Networks</h4>
            <p>{{ isset($socialLink) ? $socialLink->description : ''}}</p>
              <div class="social-links mt-3">
                <a href="{{ isset($socialLink) ? $socialLink->facebook : ''}}" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="{{ isset($socialLink) ? $socialLink->youtube : ''}}" class="youtube"><i class="bx bxl-youtube"></i></a>
                <a href="{{ isset($socialLink) ? $socialLink->twitter : ''}}" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="{{ isset($socialLink) ? $socialLink->instagram : ''}}" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="{{ isset($socialLink) ? $socialLink->linkedin : ''}}" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; <strong><script>document.write(new Date().getFullYear())</script>
            <a style="color:#f57552" title="Compant Name" href="{{ isset($generalSettings) ? $generalSettings->website : ''}}">{{ isset($generalSettings) ? $generalSettings->name : ''}}</a>,</strong>
        All rights reserved.
      </div>
      <div class="credits">
        Developed by <a href="{{ isset($generalSettings) ? $generalSettings->website : ''}}">{{ isset($generalSettings) ? $generalSettings->name : ''}}</a>
      </div>
    </div>
  </footer>
