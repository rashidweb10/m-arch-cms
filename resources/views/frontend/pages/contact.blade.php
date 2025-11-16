@extends('frontend.layouts.app')

@section('meta.title', 'Contact Us')
@section('meta.description', 'Contact Us')

@section('content')

@include('frontend.partials.breadcrumb', ['title' => "Contact Us"])

    <div class="banner_inner_slider">
      <img class="w-100" src="{{ uploaded_asset(get_setting('breadcrumb')) }}" alt="img" />
    </div>
    <!--
    <div class="container position-relative">
        <h3 class="page-heading">Contact Us from anywhere in the world</h3>
    </div>
    -->
    <div class="wave_img">
      <img class="w-100" src="{{ asset('assets/frontend/img/wave.png') }}" alt="img" />
    </div>



 <section class="contact_section py-md-5">
      <div class="container">
          <div class="contact_boxex">
        <div class="row g-4">
          
          <div class="col-lg-6 pt-0 mt-0" style="background: #f6f9fc;     border-radius: 30px 0px 0px 30px;">
          <div class="left_contact" style="    border-radius: 30px 0px 0px 30px;">
            
            <div class="text-start mb-md-5 mb-2">
              <h3 class="robot_slab text_color font-wight-400">Get in touch</h3>
            </div>

            <div class="mb-md-4 mb-2">
             
              <div class="d-flex mb-md-4 mb-2">
                <div class="flex-shrink-0 bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px">
                  <i class="fas fa-map-marker-alt text-white fs-5"></i>
                </div>
                <div class="ms-3">
                  <h3 class="h5 fw-semibold text-dark mb-md-2 mb-0">Head Office</h3>
                  <p class="text-muted mb-1">{!! get_setting('address') !!}</p>
                </div>
              </div>

              
              <div class="d-flex mb-md-4 mb-2">
                <div class="flex-shrink-0 bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px">
                  <i class="fas fa-envelope text-white fs-5"></i>
                </div>
                <div class="ms-3">
                  <h3 class="h5 fw-semibold text-dark mb-md-2 mb-0">Email Us</h3>
                  <p class="text-muted mb-1">{{get_setting('email')}}</p>
                </div>
              </div>

             
              <div class="d-flex">
                <div class="flex-shrink-0 bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px">
                  <i class="fas fa-phone-alt text-white fs-5"></i>
                </div>
                <div class="ms-3">
                  <h3 class="h5 fw-semibold text-dark mb-md-2 mb-0">Call Us</h3>
                  <p class="text-muted mb-1">Phone : {{get_setting('phone')}}</p>
                </div>
              </div>
            </div>

            <div class="pt-1 pb-md-4 pb-2">
              <!--  <hr> -->
            </div>
            <div>
             <!-- <h4 class="h5 fw-semibold text-dark mb-3">Follow our social media</h4>-->
              <div class="d-flex gap-2">
               <!--
                <a href="#" class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width:40px; height:40px">
                  <i class="fab fa-facebook-f text-white"></i>
                </a>
                <a href="#" class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width:40px; height:40px">
                  <i class="fab fa-instagram text-white"></i>
                </a>
                <a href="#" class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width:40px; height:40px">
                  <i class="fab fa-twitter text-white"></i>
                </a>
                <a href="#" class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width:40px; height:40px">
                  <i class="fab fa-youtube text-white"></i>
                </a>
                -->
              </div>
            </div>
            </div>
          </div>

          
          <div class="col-lg-6 pt-0 mt-0 bg-white" style="    border-radius: 0px 30px 30px 0px;">
            <div class="right_contact">
              
              <div class="text-start mb-md-5 mb-2">
              <h3 class="robot_slab text_color font-wight-400">Send us a message</h3>
            </div>
              

<form class="needs-validation" id="contactForm" action="{{route('form.submit')}}" method="POST" onsubmit="protect_with_recaptcha_v3(this, 'contact')">
  @include('frontend.components.form-alert')
  @csrf
  <!-- Name & Company -->
  <div class="row mb-3">
    <div class="col-md-6 mb-3 mb-md-0">
      <input type="hidden" name="form_name" value="contact">
      <label for="name" class="form-label text-muted fw-medium">Name</label>
      <input 
        type="text" 
        class="form-control" 
        id="name" 
        name="name" 
        required 
      />
      <div class="invalid-feedback">Please enter your name.</div>
    </div>
    <div class="col-md-6">
      <label for="company" class="form-label text-muted fw-medium">Company</label>
      <input 
        type="text" 
        class="form-control" 
        id="company" 
        name="company" 
        required
      />
    </div>
  </div>

  <!-- Phone & Email -->
  <div class="row mb-3">
    <div class="col-md-6 mb-3 mb-md-0">
      <label for="phone" class="form-label text-muted fw-medium">Phone</label>
      <input type="tel" class="form-control" id="phone" name="phone"
       pattern="[0-9]{10}" title="Please enter exactly 10 digits"
       maxlength="10" inputmode="numeric" required>
    </div>
    <div class="col-md-6">
      <label for="email" class="form-label text-muted fw-medium">Email</label>
      <input 
        type="email" 
        class="form-control" 
        id="email" 
        name="email" 
        required 
      />
      <div class="invalid-feedback">Please enter a valid email.</div>
    </div>
  </div>

  <!-- Subject -->
  <div class="mb-3">
    <label for="subject" class="form-label text-muted fw-medium">Subject</label>
    <input 
      type="text" 
      class="form-control" 
      id="subject" 
      name="subject" 
    />
  </div>

  <!-- Message -->
  <div class="mb-4">
    <label for="message" class="form-label text-muted fw-medium">Message</label>
    <textarea 
      class="form-control" 
      id="message" 
      name="message" 
      rows="5" 
    ></textarea>
    <div class="invalid-feedback">Please enter your message.</div>
  </div>

  <!-- Submit Button -->
  <button 
    type="submit"
    class="btn btn-primary w-100 py-3 fw-medium" 
    style="border-radius: 30px !important;"
  >
    Send
  </button>
</form>



               <div class="form-response mt-3"></div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </section>
    
    
    <div class="googlemap pt-4">
          {!! get_setting('google_map') !!}
        </div>


<script>
    $(document).ready(function () {
      $('#contactForm').on('submit', function (event) {
        event.preventDefault();

        // Run HTML5 validation
        var form = this;
        if (!form.checkValidity()) {
          event.stopPropagation();
          $(form).addClass('was-validated');
          return;
        }

        // If valid, send AJAX
        var formData = {
          name: $('#name').val(),
          company: $('#company').val(),
          phone: $('#phone').val(),
          email: $('#email').val(),
          subject: $('#subject').val(),
          message: $('#message').val()
        };

        $.ajax({
          type: 'POST',
          url: 'mail.php',
          data: formData,
          success: function (response) {
            $('.form-response').html('<div class="alert alert-success">' + response + '</div>');
            $('#contactForm')[0].reset();
            $('#contactForm').removeClass('was-validated');
          },
          error: function () {
            $('.form-response').html('<div class="alert alert-danger">Something went wrong. Try again.</div>');
          }
        });
      });
    });
  </script>        
@endsection