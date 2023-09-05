@extends('frontEnd.layouts.master')
@section('title','Wardan Tech Ltd')
<?php
    $serviceSetting = App\Models\FrontEnd\ServiceSetting::where('status', 1)->get();
    $serviceColor = App\Models\FrontEnd\ServiceColorSetting::first();
    $faqSetting = App\Models\FrontEnd\FaqSetting::where('status', 1)->get();
    $faqColor = App\Models\FrontEnd\FaqColorSetting::first();
    $aboutSetting = App\Models\FrontEnd\AboutSetting::first();
    $packageColor = App\Models\FrontEnd\PackageColorSetting::first();
    $packages = App\Models\Admin\Settings\Package::where('status', 1)->get();
    $teams = App\Models\FrontEnd\TeamSetting::where('status', 1)->get();
    $teamColor = App\Models\FrontEnd\TeamColorSetting::first();
    $generalSettings = App\Models\Admin\Settings\GeneralSetting::first();
?>
@push('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style>
    #services h2::after {
        background: {{ isset($serviceColor) ?  $serviceColor->underline_color : '' }};
    }
    #team h2::after {
        background: {{ isset($teamColor) ?  $teamColor->underline_color : '' }};
    }

    #faq h2::after {
        background: {{ isset($teamColor) ?  $teamColor->underline_color : '' }};
    }

    #about h2::after {
        background: {{ isset($aboutSetting) ?  $aboutSetting->underline_color : '' }};
    }
    #packages h2::after {
        background: {{ isset($packageColor) ?  $packageColor->underline_color : '' }};
    }
</style>
@endpush

@section('main-content')

<main id="main">
    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2 style="color:{{ isset($aboutSetting) ?  $aboutSetting->heading_color : ''}}">About Us</h2>
        </div>

        <div class="row content">
          <div class="col-lg-6">
            <ul>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img title="About Image" style="height:300px; border-radius: 15px; width:500px;" src="@isset($aboutSetting) {{ asset('img/' . $aboutSetting->image) }} @endisset"  alt="About Image">
                  </div>
            </ul>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p class="readtext" style="color:{{ isset($aboutSetting) ?  $aboutSetting->text_color : '' }}">{{ isset($aboutSetting) ? Str::words($aboutSetting->description, 100) : ' '}}</p>
            <p class="textShow" style="display: none;">{{isset($aboutSetting) ? $aboutSetting->description : ' ' }}</p>
            <a id="read-more" href="#" class="btn-learn-more collapsed" data-bs-toggle="collapse" data-bs-target="#faq" >Read More..</a>
          </div>
        </div>

      </div>
    </section>
    <!-- End About Us Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2 style="color:{{ isset($serviceColor) ?  $serviceColor->heading_color : ''}}">Services</h2>
        </div>

        <div class="row">
        @foreach ($serviceSetting as $service)
        <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
              <div class="icon"><img height="36px" width="36px" src="{{asset('img/'.$service->icon)}}" alt="Icon"></div>
              <h4><span style="color:{{ isset($serviceColor) ?  $serviceColor->title_color : '' }}">{{ $service->title }}</span></h4>
              <p style="color:{{ isset($serviceColor) ?  $serviceColor->text_color : '' }}">{{ $service->description }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section><!-- End Services Section -->

    <!-- ======= Team Section ======= -->
    <section style="background-color: #eeeeee" id="team" class="team section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2 style="color:{{ isset($teamColor) ? $teamColor->heading_color : ''}}">Team</h2>
        </div>

        <div class="row">

        @foreach ($teams as $team)
        <div class="col-lg-6 mt-4 mt-lg-0">
            <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="200">
              <div class="pic"><img title="Profile Picture" src="{{asset('img/'.$team->profile_picture)}}" class="img-fluid" alt="Profile Picture"></div>
              <div class="member-info">
                <h4 style="color:{{ isset($teamColor) ?  $teamColor->name_color : '' }}">{{ $team->name }}</h4>
                <span style="color:{{ isset($teamColor) ?  $teamColor->designation_color : '' }}">{{ $team->designation }}</span>
                <p style="color:{{ isset($teamColor) ?  $teamColor->email_color : '' }}"><i class="bx bx-envelope"></i> {{ $team->email }}</p>
                <p style="color:{{ isset($teamColor) ?  $teamColor->text_color : '' }}">{{ $team->description }}</p>
                <div class="social">
                  <a href="{{ $team->twitter }}"><i title="Twitter" class="ri-twitter-fill"></i></a>
                  <a href={{ $team->facebook }}""><i title="Facebook" class="ri-facebook-fill"></i></a>
                  <a href="{{ $team->instagram }}"><i title="Instagram" class="ri-instagram-fill"></i></a>
                  <a href="{{ $team->linkedin }}"> <i title="LinkedIn" class="ri-linkedin-box-fill"></i> </a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section><!-- End Team Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="packages" class="pricing">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2 style="color:{{ isset($packageColor) ?  $packageColor->heading_color : '' }}">Packages</h2>
        </div>

        <div class="row">

        @foreach ($packages as $item)
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="box">
              <h3 style="color:{{ isset($packageColor) ?  $packageColor->package_color : '' }}">{{ $item->name }}</h3>

              <h4 style="color:{{ isset($packageColor) ?  $packageColor->price_color : '' }}"><sup>৳</sup>{{ $item->amount }} <span style="color:{{ isset($packageColor) ?  $packageColor->month_color : '' }}">per month</span></h4>

              <ul style="color:{{ isset($packageColor) ?  $packageColor->text_color : '' }}">
                <li><i class="bx bx-check"></i> {{ $item->connections->name }}</li>
                <li><i class="bx bx-check"></i> {{ $item->package_spreed }}</li>
              </ul>
            </div>
          </div>
          @endforeach
        </div>

      </div>
    </section><!-- End Pricing Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2 style="color:{{ isset($faqColor) ?  $faqColor->heading_color : '' }}">Frequently Asked Questions</h2>
        </div>

        <div class="faq-list">
          <ul>
            @foreach ($faqSetting as $value)
            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i><a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1" style="color: {{ isset($faqColor) ?  $faqColor->question_color : '' }}">{{ $value->question }}? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                <p style="color: {{ isset($faqColor) ?  $faqColor->answer_color : '' }}">{{ $value->answer }}.</p>
              </div>
            </li>
            @endforeach
          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
        </div>
        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>{{ isset($generalSettings) ? $generalSettings->address : ' '}}</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>{{ isset($generalSettings) ? $generalSettings->email : ' '}}</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Cell:</h4>
                 <p>{{ isset($generalSettings) ? $generalSettings->phone : ' ' }}</p>
              </div>

              <iframe src="{{ isset($generalSettings) ? $generalSettings->map : ' '}}" frameborder="0" style="border:0; width:  100%; height: 290px;" allowfullscreen>
             </iframe>
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="#" method="POST" role="form" id="MessageSend" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">Your Name<span style="color:red"">*</span></label>
                  <input type="text" class="form-control" name="name" value="@if(Auth::user()) {{ Auth::user()->name }} @endif" id="name" placeholder="Enter Your name" required>

                </div>
                <div class="form-group col-md-6">
                  <label for="name">Your Email<span style="color:red"">*</span></label>
                  <input type="email" class="form-control" name="email" value="@if(Auth::user()) {{ Auth::user()->email }} @endif " id="email" placeholder="Enter Your Email" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Subject<span style="color:red"">*</span></label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter A Subject" required>
              </div>
              <div class="form-group">
                <label for="name">Message<span style="color:red"">*</span></label>
                <textarea class="form-control" name="message" id="message" rows="10" placeholder="Write your message here.." required></textarea>
              </div>
              <div class="my-3" id="buttonHide">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div style="background: green" class="alert alert-success alert-dismissible" >
                    <span style="cursor: pointer;background:red" class="close" data-dismiss="alert" aria-label="close">&times;</span>
                    <strong style="color:white" id="msg"></strong>
                  </div>
              </div>
              <div class="text-center"><button type="submit" id="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main>
    @push('js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $("#buttonHide").hide();
        $(document).ready(function(){
            $(".close").click(function(){
             $("#buttonHide").hide();
            });

            $("#read-more").click(function(){
            $(".readtext").hide();
            $(".textShow").show();
            $("#read-more").hide();
            });
        });

    $('#submit').on('click',function(e){
    e.preventDefault();

    let name = $('#name').val();
    let email = $('#email').val();
    let subject = $('#subject').val();
    let message = $('#message').val();

    $.ajax({
      url: "{{ route('admin.message-store') }}",
      type:"POST",
      data:{
        "_token": "{{ csrf_token() }}",
        name:name,
        email:email,
        subject:subject,
        message:message,
      },

      success:function(data)
        {
            if(data.status == 200){
               $('#msg').append(data.success);
               $("#buttonHide").show();
               $('#MessageSend')[0].reset();
            }
        }

      });
    });
    </script>
    @endpush
  @endsection
