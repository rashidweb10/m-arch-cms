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
            <h2 class="fw-bold mb-4 robot_slab ">Get in touch</h2>
            <!-- Head Office -->
            <div class="d-flex border_bottoms icon_hovers">
               <div class="icon-circle me-3" style="width: 54px;">
                  <i class="fa-solid fa-map"></i>
               </div>
               <div>
                  <h5 class="fw-semibold mb-1">MarinArch – Online Coaching Classes</h5>
                  <p class="mb-0 text-muted"><strong>Address:</strong> Soham Tropical Lagoon,
                     In front of Swaraswati Vidhyalaya, Kavesar, Off Ghodbunder Road,
                     Thane - 400615 Maharashtra India.
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
                  <p class="mb-0 text-muted">info@marinarch.in</p>
               </div>
            </div>
            <!-- Call Us -->
            <div class="d-flex mb-4 icon_hovers">
               <div class="icon-circle me-3">
                  <i class="fa-solid fa-phone"></i>
               </div>
               <div>
                  <h5 class="fw-semibold mb-1">Call Us</h5>
                  <p class="mb-0 text-muted">+91 9920062295</p>
               </div>
            </div>
            <!-- Social Media -->
            <div class="mt-5">
               <h5 class="fw-semibold mb-3 robot_slab ">Follow our social media</h5>
               <div class="d-flex gap-2">
                  <a href="#" class="icon-circle"><i class="fa-brands fa-facebook"></i></a>
                  <a href="#" class="icon-circle"><i class="fa-brands fa-instagram"></i></a>
                  <a href="#" class="icon-circle"><i class="fa-brands fa-twitter"></i></a>
                  <a href="#" class="icon-circle"><i class="fa-brands fa-youtube"></i></a>
               </div>
            </div>
         </div>
         <!-- Right Side - Contact Form -->
         <div class="col-lg-6">
            <div class="bg-light p-4 p-md-5 rounded-3 shadow-sm">
               <h3 class="fw-bold mb-4 robot_slab ">Send us a message</h3>
               <form>
                  <!-- Name and Company -->
                  <div class="row g-3">
                     <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Name">
                     </div>
                     <div class="col-md-6">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" class="form-control" id="company" placeholder="Company">
                     </div>
                  </div>
                  <!-- Phone and Email -->
                  <div class="row g-3 mt-1">
                     <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Phone">
                     </div>
                     <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email">
                     </div>
                  </div>
                  <!-- Subject -->
                  <div class="mt-3">
                     <label for="subject" class="form-label">Subject</label>
                     <input type="text" class="form-control" id="subject" placeholder="Subject">
                  </div>
                  <!-- Message -->
                  <div class="mt-3">
                     <label for="message" class="form-label">Message</label>
                     <textarea class="form-control" id="message" rows="5" placeholder="Message"></textarea>
                  </div>
                  <!-- Button -->
                  <button type="submit" class="btn btn-primary w-100 py-2 mt-4 fs-5">
                  Send
                  </button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<iframe style="margin-bottom: -7px;" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3766.370979156978!2d72.96844317503248!3d19.26622688197789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1763804983333!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>       
@endsection