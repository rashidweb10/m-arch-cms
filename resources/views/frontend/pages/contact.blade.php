@extends('frontend.layouts.app')

@section('meta.title', 'Contact Us')
@section('meta.description', 'Contact Us')

@section('content')

@include('frontend.partials.breadcrumb', ['title' => "Contact Us"])

<section class="py-5">
   <div class="container">
      <div class="row g-5">
         <!-- Left Side -->
         <div class="col-lg-6">
            <h3 class=" mb-4 robot_slab ">Get in touch</h3>
            <!-- Head Office -->
            <div class="d-flex border_bottoms icon_hovers">
               <div class="icon-circle me-3" style="width: 54px;">
                  <i class="fa-solid fa-map"></i>
               </div>
               <div>
                  <h5 class="fw-semibold mb-1">MarinArch – Online Coaching Classes</h5>
                  <p class="mb-0 text-muted"><strong>Address:</strong> {!! get_setting('address') !!}
                  </p>
               </div>
            </div>
            <!-- Email Us -->
            <div class="d-flex border_bottoms icon_hovers">
               <div class="icon-circle me-3">
                  <i class="fa-solid fa-envelope"></i>
               </div>
               <div>
                  <h5 class="fw-semibold mb-1">Email Us</h5>
                  <p class="mb-0 text-muted">{{get_setting('email')}}</p>
               </div>
            </div>
            <!-- Call Us -->
            <div class="d-flex mb-4 icon_hovers">
               <div class="icon-circle me-3">
                  <i class="fa-solid fa-phone"></i>
               </div>
               <div>
                  <h5 class="fw-semibold mb-1">Call Us</h5>
                  <p class="mb-0 text-muted">{{get_setting('phone')}}</p>
               </div>
            </div>
            
            
            {!! get_setting('google_map') !!}
            
            
            <!-- Social Media -->
            <!--<div class="mt-5">-->
            <!--   <h5 class="fw-semibold mb-3 robot_slab ">Follow our social media</h5>-->
            <!--   <div class="d-flex gap-2">-->
            <!--      <a href="{{ get_setting('facebook_url') }}" class="icon-circle"><i class="fa-brands fa-facebook"></i></a>-->
            <!--      <a href="{{ get_setting('instagram_url') }}" class="icon-circle"><i class="fa-brands fa-instagram"></i></a>-->
            <!--      <a href="{{ get_setting('x_url') }}" class="icon-circle"><i class="fa-brands fa-twitter"></i></a>-->
            <!--      <a href="{{ get_setting('youtube_url') }}" class="icon-circle"><i class="fa-brands fa-youtube"></i></a>-->
            <!--   </div>-->
            <!--</div>-->
         </div>
         <!-- Right Side - Contact Form -->
         <div class="col-lg-6">
            <div class="bg-light p-4 p-md-5 rounded-3 shadow-sm">
               <h3 class=" mb-4 robot_slab ">Send us a message</h3>

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
    class="cnotact_btns btn btn-primary py-2 mt-1 fs-5"
  >
    Send
  </button>
</form>


            </div>
         </div>
      </div>
   </div>
</section>

@endsection