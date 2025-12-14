@extends('frontend.layouts.app')

@section('meta.title', $pageData->seo_title)
@section('meta.description', $pageData->seo_description)

@section('content')
@php
  $banner_images = $pageData->meta->where('meta_key', 'banner_images')->first()->meta_value ?? '';
  $about = json_decode($pageData->meta->where('meta_key', 'about')->first()->meta_value ?? '[]', true);
  $partner_title = $pageData->meta->where('meta_key', 'partner_title')->first()->meta_value ?? '';
  $partner_description = $pageData->meta->where('meta_key', 'partner_description')->first()->meta_value ?? '';
  $partners = json_decode($pageData->meta->where('meta_key', 'partners')->first()->meta_value ?? '[]', true);
@endphp

@include('frontend.partials.breadcrumb', ['title' => $pageData->title])

<!--about us section start-->
<section class="about_section pt-0 pt-md-5 pb-md-5 position-relative">
   <div class="container position-relative">
      <div class="row">
         <div class="col-md-7"></div>
         <div class="col-lg-5">
            <div class="admission_form">
               <h4 class="robot_slab text_color pt-70 robot_slab pb-3">Admission Enquiry Form</h4>
               <form method="post" action="" id="admissionForm" onsubmit="">
                  <div class="row">
                     <div class="col-md-12 col-12 mb-3">
                        <div class="form-outline">
                           <input type="text" class="form-control" name="name" placeholder="Name*" required="">
                        </div>
                     </div>
                     <div class="col-md-12 col-6 mb-3">
                        <div class="form-outline">
                           <input type="text" class="form-control" name="phone" placeholder="Mobile Number*" required="" pattern="\d{10}" maxlength="10" title="Please enter a valid 10-digit mobile number">
                        </div>
                     </div>
                     <div class="col-md-12 col-12 mb-3">
                        <div class="form-outline">
                           <input type="email" class="form-control" name="email" placeholder="Email ID*" required="">
                        </div>
                     </div>
                     <div class="col-md-12 col-12 mb-3">
                        <div class="form-outline">
                           <textarea type="text" class="form-control" name="message" placeholder="Comment" ></textarea>
                        </div>
                     </div>
                     <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-lg-8 paddngrgt80" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
            <div class="text-start mb-md-4 mb-2 pt-4">
               <h3 class="roboto text_color roboto fw-normal robot_slab ">Welcome to MarinArch Academy</h3>
            </div>
            <p>
               MarinArch is a live tutorial session which prepare the candidates in the systematic way to excel their Marine Engineer Officer exams. It is the most convenient and economical way to prepare for the MEO exams.
            </p>
            <p>
               It's result oriented program where lectures are conducted by qualified person in marine field. A candidate can do the group study sitting at his/her/ home from any part of world so no waste of time and money in travelling and boarding.
            </p>
            <p>
               In MarinArch, the study material is provided to the candidates. It’s a 2way session, a lot of discussions. The provision of MOC orals is also there for the candidate.
            </p>
         </div>
         <div class="col-lg-4 col-12 pt-5" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
            <div class="about_border border_6 position-relative">
               <img class="hvr-bounce-in aboutimgss" src="assets/frontend/img/marinarch-logo.png" alt="img" />
            </div>
         </div>
      </div>
   </div>
</section>
<section class="courses_we_offered pt-4 pt-md-5 pb-md-5 pb-4 position-relative" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-12 aos-init aos-animate">
            <div class="text-start mb-md-4 mb-2 pt-2">
               <h3 class="robot_slab text_color text-left">Courses we offered</h3>
            </div>
         </div>
         <div class="owl-carousel curseswe_offer">
            <div class="item">
               <div class="aos-init aos-animate position-relative">
                  <div class="offered_box">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/deck-courses.jpg" alt="">
                     <p class="text-center pt-1">Deck Courses</p>
                  </div>
               </div>
            </div>
            <div class="item">
               <div class="aos-init aos-animate position-relative">
                  <div class="offered_box">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/engineering-courses.jpg" alt="">
                     <p class="text-center pt-1">Engineering Courses</p>
                  </div>
               </div>
            </div>
            <div class="item">
               <div class="aos-init aos-animate position-relative">
                  <div class="offered_box">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/extra-first-class-exams.jpg" alt="">
                     <p class="text-center pt-1">Extra First Class Exams</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section id="counter" class="statistics-section about-us" >
   <div class="container">
      <div class="row">
         <div class="col-md-3 col-6 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="stastic  startimg ">
               <div class="counter-value robot_slab" data-count="3">1+</div>
               <p class="robot_slab">Years in Teaching</p>
            </div>
         </div>
         <div class="col-md-3 col-6 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="stastic  startimg ">
               <div class="counter-value robot_slab" data-count="8">1+</div>
               <p class="robot_slab">Courses</p>
            </div>
         </div>
         <div class="col-md-3 col-6 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="stastic  startimg ">
               <div class="counter-value robot_slab" data-count="6">1+</div>
               <p class="robot_slab">Faculties</p>
            </div>
         </div>
         <div class="col-md-3 col-6 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="stastic  startimg ">
               <div class="counter-value robot_slab" data-count="63">1+</div>
               <p class="robot_slab">Students Passed</p>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="gallery_section">
   <div class="bgcolor pb-4 pt-4 pb-md-5 pt-md-5">
      <div class="container">
         <div class="text-start mb-md-4 mb-2 pt-2">
            <h3 class="robot_slab text_color text-center">Why MarinArch</h3>
         </div>
         <div class="row">
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
               <a class="text-decoration-none text-dark" href="campus-facilities.html">
                  <div class="classroom_box border_2 position-relative">
                     <img class="hvr-bounce-in w-100" src="assets/frontend/img/career.jpg" alt="Image 1">
                     <div class=" text-center pt-3">
                        <p class="robot_slab centered-text">Career Achievements</p>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
               <a class="text-decoration-none text-dark" href="campus-facilities.html">
                  <div class="classroom_box border_2 position-relative">
                     <img class="hvr-bounce-in w-100" src="assets/frontend/img/flexibility.jpg" alt="Image 1">
                     <div class=" text-center pt-3">
                        <p class="centered-text robot_slab ">Flexibility</p>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
               <a class="text-decoration-none text-dark" href="campus-facilities.html">
                  <div class="classroom_box border_2 position-relative">
                     <img class="hvr-bounce-in w-100" src="assets/frontend/img/cost-effective.jpg" alt="Image 1">
                     <div class=" text-center pt-3">
                        <p class="centered-text robot_slab ">Cost Effective</p>
                     </div>
                  </div>
               </a>
            </div>
         </div>
      </div>
   </div>
</section>

@endsection
