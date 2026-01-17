@extends('frontend.layouts.app')
    
@section('meta.title', $pageData->seo_title)
@section('meta.description', $pageData->seo_description)

@section('content')

@php

  $banner_title = $pageData->meta->where('meta_key', 'banner_title')->first()->meta_value ?? '';
  $banner_images = $pageData->meta->where('meta_key', 'banner_images')->first()->meta_value ?? '';

  $about_title = $pageData->meta->where('meta_key', 'about_title')->first()->meta_value ?? '';
  $about_description = $pageData->meta->where('meta_key', 'about_description')->first()->meta_value ?? '';
  $about_image = $pageData->meta->where('meta_key', 'about_image')->first()->meta_value ?? '';

  $about_title2 = $pageData->meta->where('meta_key', 'about_school_title')->first()->meta_value ?? '';
  $about_description2 = $pageData->meta->where('meta_key', 'about_school_description')->first()->meta_value ?? '';

  $milestones = json_decode($pageData->meta->where('meta_key', 'home_milestones')->first()->meta_value ?? '[]', true);

  $achievement_title = $pageData->meta->where('meta_key', 'achievement_title')->first()->meta_value ?? '';
  $achievement_description = $pageData->meta->where('meta_key', 'achievement_description')->first()->meta_value ?? '';
  $achievement_image = $pageData->meta->where('meta_key', 'achievement_image')->first()->meta_value ?? ''; 
  
  $home_awards = json_decode($pageData->meta->where('meta_key', 'home_awards')->first()->meta_value ?? '[]', true);

  $video = $pageData->meta->where('meta_key', 'video')->first()->meta_value ?? '';

  $quicklinks = json_decode($pageData->meta->where('meta_key', 'home_quicklinks')->first()->meta_value ?? '[]', true);
@endphp

<div class="banner_height position-relative">
    <video width="100%" height="100%" class="elVideo" loop="loop" autoplay="" playsinline="" muted=""
   src="{{ uploaded_asset($banner_images) }}" id="video-slider-1"></video>
    <div class="position-absolute hero_content translate-middle text-center text-white" style="z-index: 10;">
        <h1 class="display-4 fw-bold mb-3">
           Train today to become <span>tomorrow's maritime leader,</span>
         
        </h1>
        <h4>
         
        MarinArch Consultants offers <span>a strong career at sea and beyond. </span></h4>
        <a href="https://www.google.com/search?sca_esv=eb783835d62ec6f7&rlz=1C1SLLM_enIN1120IN1120&si=AL3DRZEsmMGCryMMFSHJ3StBhOdZ2-6yYkXd_doETEE1OR-qOSOXx31BNcQ1ajSXd2D9ZuQC7kMPdaCdKMY0Xm0lPIgc-R5Jf8M93s6HO0-qu1rqhvw0o8RUmQBjbCy-SEAqrlroqq_Q&q=Marin+Arch+Reviews&sa=X&ved=2ahUKEwimyJPhso2SAxWoUGwGHWLJC_8Q0bkNegQIIhAH&biw=1600&bih=731&dpr=1&aic=0" target="_blank"><img src="/assets/frontend/img/review_img.jpeg" class="img-fluid" alt="Reviews" /></a>
        
    </div>
</div>

<!--about us section start-->
<section class="about_section pt-0 pt-md-5 pb-md-5 position-relative">
   <div class="container">
      <div class="row">
         <div class="col-lg-8 ">
            <div class="text-start">
               <div class="skew-box ">
                  <p class="robot_slab text_color">{{ $banner_title }}</p>
               </div>
            </div>
         </div>
         <div class="col-lg-8 order-md-1 order-2 paddngrgt80" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
            <div class="text-start mb-md-4 mb-2 pt-md-4 pt-0">
               <h3 class=" text_color robot_slab fw-normal">{{ $about_title }}</h3>
            </div>
            <div>
               {!! $about_description !!}
            </div>
         </div>
         <div class="col-lg-4 col-12 pt-md-5 pb-md-0 pb-4 pt-2 order-md-2 order-1" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
            <div class="about_border border_6 position-relative">
               <img class="hvr-bounce-in aboutimgss" src="{{ uploaded_asset($about_image) }}" alt="img" />
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Enroll Section with Images -->
<section class="enroll-images-section pt-md-5 pb-md-5  pt-4 pb-4">
   <div class="container">
      <div class="row g-4 align-items-center">
         <!-- Single Image Column - Online Course -->
         <div class="col-md-4" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
            <a href="{{ route('courses') }}#online-course" class="text-decoration-none">
               <div class="enroll-image-box position-relative">
                  <img class="w-100 hvr-bounce-in" src="/assets/frontend/img/course-1.jpg" alt="MarinArch Training">
                  <div class="image-label">
                     <span class="robot_slab">Online Course</span>
                  </div>
               </div>
            </a>
         </div>
         
         <!-- Two Images Column - Offline Course -->
         <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <a href="{{ route('courses') }}#offline-course" class="text-decoration-none">
               <div class="enroll-images-stacked">
                  <div class="enroll-image-box position-relative">
                     <img class="w-100 hvr-bounce-in" src="/assets/frontend/img/course-2.jpg" alt="MarinArch Training">
                     <div class="image-label">
                        <span class="robot_slab">Offline Course</span>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         
         <!-- Enroll Form Column -->
         <div class="col-md-4" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
            <div class="enroll-form-box">
               <h3 class="robot_slab text_color mb-4">Enroll Now</h3>
               @include('frontend.components.enrolment-enquiry')
            </div>
         </div>
      </div>
   </div>
</section>

<!-- @include('frontend.partials.course-carousel') -->

      
<section class="client_section1 py-lg-5" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
          <div class="">
            
                <div class="text-center ">
                  <h3 class="robot_slab text_color  mb-md-4 mb-2 pt-2">Students Review</h3>
                </div>
              
          
          <div class="services-scroll-container">
            <div class="services-scroll-wrapper">
              <ul class="services-scroll-list">
                <li class="services-scroll-item">
               
                   <a href="/assets/frontend/img/testiimg_1.jpeg"
                 data-fancybox="album1"
                 data-caption=""
                 class="d-block position-relative services-box-link">
                       <div class="services_boxs">
                        <img class="jbox-img rotate w-100" src="/assets/frontend/img/testiimg_1.jpeg" alt="">
                       
                      </div>
              </a>
                </li>
                
                 <li class="services-scroll-item">
               
                   <a href="/assets/frontend/img/testiimg_2.jpeg"
                 data-fancybox="album1"
                 data-caption=""
                 class="d-block position-relative services-box-link">
                       <div class="services_boxs">
                        <img class="jbox-img rotate w-100" src="/assets/frontend/img/testiimg_2.jpeg" alt="">
                       
                      </div>
              </a>
                </li>
                
                 <li class="services-scroll-item">
               
                   <a href="/assets/frontend/img/testiimg_3.jpeg"
                 data-fancybox="album1"
                 data-caption=""
                 class="d-block position-relative services-box-link">
                       <div class="services_boxs">
                        <img class="jbox-img rotate w-100" src="/assets/frontend/img/testiimg_3.jpeg" alt="">
                       
                      </div>
              </a>
                </li>
                
                 <li class="services-scroll-item">
               
                   <a href="/assets/frontend/img/testiimg_4.jpeg"
                 data-fancybox="album1"
                 data-caption=""
                 class="d-block position-relative services-box-link">
                       <div class="services_boxs">
                        <img class="jbox-img rotate w-100" src="/assets/frontend/img/testiimg_4.jpeg" alt="">
                       
                      </div>
              </a>
                </li>
                
                 <li class="services-scroll-item">
               
                   <a href="/assets/frontend/img/testiimg_5.jpeg"
                 data-fancybox="album1"
                 data-caption=""
                 class="d-block position-relative services-box-link">
                       <div class="services_boxs">
                        <img class="jbox-img rotate w-100" src="/assets/frontend/img/testiimg_5.jpeg" alt="">
                       
                      </div>
              </a>
                </li>
                
                 <li class="services-scroll-item">
               
                   <a href="/assets/frontend/img/testiimg_6.jpeg"
                 data-fancybox="album1"
                 data-caption=""
                 class="d-block position-relative services-box-link">
                       <div class="services_boxs">
                        <img class="jbox-img rotate w-100" src="/assets/frontend/img/testiimg_6.jpeg" alt="">
                       
                      </div>
              </a>
                </li>
                
                
                 <li class="services-scroll-item">
               
                   <a href="/assets/frontend/img/testiimg_7.jpeg"
                 data-fancybox="album1"
                 data-caption=""
                 class="d-block position-relative services-box-link">
                       <div class="services_boxs">
                        <img class="jbox-img rotate w-100" src="/assets/frontend/img/testiimg_7.jpeg" alt="">
                       
                      </div>
              </a>
                </li>
                <li class="services-scroll-item">
               
               <a href="/assets/frontend/img/testiimg_8.jpeg"
             data-fancybox="album1"
             data-caption=""
             class="d-block position-relative services-box-link">
                   <div class="services_boxs">
                    <img class="jbox-img rotate w-100" src="/assets/frontend/img/testiimg_8.jpeg" alt="">
                   
                  </div>
          </a>
            </li>
               
               
              </ul>
            </div>
            
            

          </div>
          
          </div>
        </section>



<section class="scholar_section mt-lg-5 pb-lg-5 position-relative z-index-9">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-10 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="text-start mb-md-4 mb-2 pt-md-0">
               <h3 class="robot_slab  text_color text-center fw-normal">{{ $about_title2 }}</h3>
            </div>
            <p class="text-center padd190">
            {!! $about_description2 !!}
            </p>
            <div class="read-more text-center mb-md-5">
               <a href="{{ route('about') }}" class="btn-2 robot_slab">Read More</a>
            </div>
         </div>
      </div>
   </div>
</section>

@if(isset($milestones['itration']) && is_array($milestones['itration']))
<section id="counter" class="statistics-section about-us" >
   <div class="container">
      <div class="row">
         @foreach($milestones['itration'] as $index => $itration)
         <div class="col-md-3 col-6 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="stastic  @if($loop->last) @else startimg @endif ">
               <div class="counter-value robot_slab" data-count="{{$milestones['title'][$index]}}">1+</div>
               <p class="robot_slab">{{$milestones['description'][$index]}}</p>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>
@endif

<section class="pt-5 pt-md-5 pb-md-5">
   <div class="container paddlft50 pt-md-5">
      <div class="row align-items-center justify-content-center">
         <div class="col-lg-4">
            <div class="about_border border_10" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
               <img class="hvr-bounce-in w-100" src="{{ uploaded_asset($achievement_image) }}" alt="img" />
            </div>
         </div>
         <div class="col-lg-8 ps-md-4" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
            <div class="education_box">
               <div class="text-start mb-md-3 mb-2 pt-2">
                  <h3 class="roboto text_color robot_slab">{{ $achievement_title }}</h3>
               </div>
               <p>
               <p>
                  {!! $achievement_description !!}
               </p>
            </div>
         </div>
      </div>
   </div>
</section>

@if(isset($home_awards['itration']) && is_array($home_awards['itration']))
<!--<section class="awards_achievements pt-4 pt-md-5 pb-0 position-relative" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">-->
<!--   <div class="container">-->
<!--      <div class="row justify-content-center">-->
<!--         <div class="col-lg-12 aos-init aos-animate">-->
<!--            <div class="text-start mb-md-4 mb-2 pt-2">-->
<!--               <h3 class="roboto text_color text-center robot_slab">Awards & Accolades</h3>-->
<!--            </div>-->
<!--         </div>-->
<!--         <div class="row">-->

<!--            @foreach($home_awards['itration'] as $index => $itration)-->
<!--            <div class="col-md-3">-->
<!--               <div class="aos-init aos-animate position-relative">-->
<!--                  <div class="about_border border_9 position-relative">-->
<!--                     <a href="{{ uploaded_asset($home_awards['image'][$index]) }}" data-fancybox="gallery1">-->
<!--                     <img class="jbox-img rotate w-100 hvr-bounce-in" src="{{ uploaded_asset($home_awards['image'][$index]) }}" alt="{{ central_asset(uploaded_asset($home_awards['title'][$index])) }}">-->
<!--                     </a>-->
<!--                  </div>-->
<!--               </div>-->
<!--            </div>-->
<!--            @endforeach-->

<!--         </div>-->
<!--         {{-- <div class="read-more text-center mt-4">-->
<!--            <a href="/" class="btn-2 robot_slab">View All</a>-->
<!--         </div> --}}-->
<!--      </div>-->
<!--   </div>-->
<!--</section>-->
@endif

@if(!empty($video))
<section class="awards_achievements pt-4 pt-md-5 pb-0 position-relative" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-12">
            <!--<iframe width="100%" height="345" src="{{ $video }}" title="Royal Caribbean Odyssey of the Seas | Full Walkthrough Ship Tour" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>-->
            <video controls style="width:100%;">
    <source src="/assets/frontend/img/marine_video.mp4" type="video/mp4">
  </video>
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
@endif

@if(isset($quicklinks['itration']) && is_array($quicklinks['itration']))
<section class="gallery_section">
   <div class="bgcolor pb-4 pt-4 pb-md-5 pt-md-5">
      <div class="container">
         <div class="text-start mb-md-4 mb-2 pt-2">
            <h3 class="robot_slab text_color text-center">Why MarinArch</h3>
         </div>
         <div class="row">

            @foreach($quicklinks['itration'] as $index => $itration)  
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
               <a class="text-decoration-none text-dark" href="{{$quicklinks['url'][$index]}}">
                  <div class="classroom_box border_2 position-relative">
                     <img class="hvr-bounce-in w-100" src="{{ uploaded_asset($quicklinks['icon'][$index]) }}" alt="Image {{ $index }}">
                     <div class=" text-center pt-md-3">
                        <p class="robot_slab centered-text">{{$quicklinks['title'][$index]}}</p>
                     </div>
                  </div>
               </a>
            </div>
            @endforeach

         </div>
      </div>
   </div>
</section>
@endif

@push('scripts')
<script>
   $(document).ready(function() {
      // Handle home enroll form submission
      $('#homeEnrollForm').on('submit', function(e) {
         e.preventDefault();
         
         var courseType = $('input[name="courseType"]:checked').val();
         var course = $('#homeCourseSelect').val();
         
         if (!course) {
            alert('Please select a course');
            return;
         }
         
         // Here you can add AJAX call to submit enrollment
         // For now, just show an alert
         alert('Enrollment request submitted for: ' + course + ' (' + courseType + ')');
         
         // Reset form
         $('#homeEnrollForm')[0].reset();
         $('#homeOnlineType').prop('checked', true);
      });
   });
</script>
@endpush

@endsection
