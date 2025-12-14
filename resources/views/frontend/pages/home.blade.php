@extends('frontend.layouts.app')
    
@section('meta.title', $pageData->seo_title)
@section('meta.description', $pageData->seo_description)

@section('content')

@php
  $banner_images = explode(',', $pageData->meta->where('meta_key', 'banner_images')->first()->meta_value ?? '');
  $about_title = $pageData->meta->where('meta_key', 'about_title')->first()->meta_value ?? '';
  $about_description = $pageData->meta->where('meta_key', 'about_description')->first()->meta_value ?? '';
  $about_image = $pageData->meta->where('meta_key', 'about_image')->first()->meta_value ?? '';
  $industries_title = $pageData->meta->where('meta_key', 'industries_title')->first()->meta_value ?? '';
  $industries_description = $pageData->meta->where('meta_key', 'industries_description')->first()->meta_value ?? '';
  $industries = json_decode($pageData->meta->where('meta_key', 'industries')->first()->meta_value ?? '[]', true);
@endphp

<video width="100%" height="100%" class="elVideo" loop="loop" autoplay="" playsinline="" muted=""
   src="assets/frontend/img/home-video.mp4" id="video-slider-1"></video>
<!--about us section start-->
<section class="about_section pt-0 pt-md-5 pb-md-5 position-relative">
   <div class="container">
      <div class="row">
         <div class="col-lg-8 ">
            <div class="text-start mb-md-4 mb-2 pt-md-4">
               <div class="skew-box ">
                  <p class="robot_slab text_color">Embracing each student's individuality and helping them thrive.</p>
               </div>
            </div>
         </div>
         <div class="col-lg-8 paddngrgt80" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
            <div class="text-start mb-md-4 mb-2 pt-4">
               <h3 class=" text_color robot_slab fw-normal">Welcome to MarinArch Academy</h3>
            </div>
            <p> MarinArch is a live tutorial session which prepare the candidates in the systematic way to excel their Marine Engineer Officer exams. It is the most convenient and economical way to prepare for the MEO exams. </p>
            <p> It's result oriented program where lectures are conducted by qualified person in marine field. A candidate can do the group study sitting at his/her/ home from any part of world so no waste of time and money in travelling and boarding. </p>
            <p> In MarinArch, the study material is provided to the candidates. It’s a 2way session, a lot of discussions. The provision of MOC orals is also there for the candidate. </p>
         </div>
         <div class="col-lg-4 col-12 pt-5" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
            <div class="about_border border_6 position-relative">
               <img class="hvr-bounce-in aboutimgss" src="assets/frontend/img/marinarch-logo.png" alt="img" />
            </div>
         </div>
      </div>
   </div>
</section>
<section class="courses_we_offered pt-4 pt-md-5 pb-0 position-relative" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
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
<section class="scholar_section mt-lg-5 pb-lg-5 position-relative z-index-9">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-10 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="text-start mb-md-4 mb-2 pt-md-0">
               <h3 class="roboto text_color text-center fw-normal">MarineArch Online Academy for Merchant Navi</h3>
            </div>
            <p class="text-center padd190">
            <p>Our vibrant and serene campus where our students explore, enjoy and experience active learning. The classrooms are spacious and well ventilated, equipped with modern amenities. We have updated our curriculum as per New Education Policy and we are affiliated to CBSE.</p>
            </p>
            <div class="read-more text-center mb-5">
               <a href="/about-us.php" class="btn-2 robot_slab">Read More</a>
            </div>
         </div>
      </div>
   </div>
</section>
<section id="counter" class="statistics-section about-us">
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
<section class="pt-5 pt-md-5 pb-md-5">
   <div class="container paddlft50 pt-md-5">
      <div class="row align-items-center justify-content-center">
         <div class="col-lg-4">
            <div class="about_border border_10" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
               <img class="hvr-bounce-in w-100" src="assets/frontend/img/deck-courses.jpg" alt="img" />
            </div>
         </div>
         <div class="col-lg-8 ps-md-4" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
            <div class="education_box">
               <div class="text-start mb-md-3 mb-2 pt-2">
                  <h3 class="roboto text_color robot_slab">Achieving Excellence through the Education</h3>
               </div>
               <p>
               <p>We combine academic rigor with creative expression, character building, and practical learning to ensure a well-rounded development. Our dedicated faculty, modern infrastructure, and student-centred approach creates an environment where learners are encouraged to question, explore, and excel from classroom to co-curricular arena.</p>
               </p>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="awards_achievements pt-4 pt-md-5 pb-0 position-relative" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-12 aos-init aos-animate">
            <div class="text-start mb-md-4 mb-2 pt-2">
               <h3 class="roboto text_color text-center robot_slab">Awards & Accolades</h3>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3">
               <div class="aos-init aos-animate position-relative">
                  <div class="about_border border_9 position-relative">
                     <a href="assets/frontend/img/aboutus.png" data-fancybox="gallery1">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/aboutus.png" alt="">
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="aos-init aos-animate position-relative">
                  <div class="about_border border_9 position-relative">
                     <a href="assets/frontend/img/aboutus.png" data-fancybox="gallery1">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/aboutus.png" alt="">
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="aos-init aos-animate position-relative">
                  <div class="about_border border_9 position-relative">
                     <a href="assets/frontend/img/aboutus.png" data-fancybox="gallery1">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/aboutus.png" alt="">
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="aos-init aos-animate position-relative">
                  <div class="about_border border_9 position-relative">
                     <a href="assets/frontend/img/aboutus.png" data-fancybox="gallery1">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/aboutus.png" alt="">
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="read-more text-center mt-4">
            <a href="/" class="btn-2 robot_slab">View All</a>
         </div>
      </div>
   </div>
</section>
<section class="awards_achievements pt-4 pt-md-5 pb-0 position-relative" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-7">
            <iframe width="100%" height="345" src="https://www.youtube.com/embed/bmmYE4wX-jE" title="Royal Caribbean Odyssey of the Seas | Full Walkthrough Ship Tour" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
         </div>
         <div class="col-md-5">
            <div class="owl-carousel achievements">
               <div class="item">
                  <div class="testiminials ">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/aboutus.png" alt="">
                  </div>
               </div>
               <div class="item">
                  <div class="testiminials ">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/aboutus.png" alt="">
                  </div>
               </div>
               <div class="item">
                  <div class="testiminials ">
                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="assets/frontend/img/aboutus.png" alt="">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="gallery_section">
   <div class="bgcolor pb-4 pt-4 pb-md-5 pt-md-5">
      <div class="container">
         <div class="text-start mb-md-4 mb-2 pt-2">
            <h3 class="roboto text_color text-center robot_slab">Why MarinArch</h3>
         </div>
         <div class="row">
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
               <a class="text-decoration-none text-dark" href="/">
                  <div class="classroom_box border_2 position-relative">
                     <img class="hvr-bounce-in w-100" src="assets/frontend/img/career.jpg" alt="Image 1">
                     <div class=" text-center pt-3">
                        <p class="centered-text robot_slab">Career Achievements</p>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
               <a class="text-decoration-none text-dark" href="/">
                  <div class="classroom_box border_2 position-relative">
                     <img class="hvr-bounce-in w-100" src="assets/frontend/img/flexibility.jpg" alt="Image 1">
                     <div class=" text-center pt-3">
                        <p class="centered-text robot_slab">Flexibility</p>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
               <a class="text-decoration-none text-dark" href="/">
                  <div class="classroom_box border_2 position-relative">
                     <img class="hvr-bounce-in w-100" src="assets/frontend/img/cost-effective.jpg" alt="Image 1">
                     <div class=" text-center pt-3">
                        <p class="centered-text robot_slab">Cost Effective</p>
                     </div>
                  </div>
               </a>
            </div>
         </div>
      </div>
   </div>
</section>

@endsection
