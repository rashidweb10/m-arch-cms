@extends('frontend.layouts.app')

@section('meta.title', $pageData->seo_title)
@section('meta.description', $pageData->seo_description)

@section('content')

@php
  $about_title = $pageData->meta->where('meta_key', 'about_title')->first()->meta_value ?? '';
  $about_description = $pageData->meta->where('meta_key', 'about_description')->first()->meta_value ?? '';
@endphp

@include('frontend.partials.breadcrumb', ['title' => $pageData->title, 'image' => $pageData->meta->where('meta_key', 'banner_images')->first()->meta_value ?? ''])

<section class="py-5 px-3 position-relative">
   <div class="container">
      <!-- Header -->
      <div class="text-center mb-5">
         <h2 class="fw-bold display-5 text-primary mb-3 robot_slab " style="background: linear-gradient(90deg, #0077b6, #00b4d8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            {!! $about_title !!}
         </h2>
         <div class="section-divider mb-3"></div>
         <p class="text-muted mx-auto" style="max-width: 700px;">
            {!! $about_description !!}
         </p>
      </div>
      <!-- Faculty Grid -->
      <div class="row g-5">
         <!-- Faculty 1 -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/archana.jpg" alt="Ms Archana Saxena Sangal" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Ms Archana Saxena Sangal</h5>
                     <p class="faculty-description">
                        (Director of MarinArch, CE, Ex Technical Superintendent)
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Faculty 7 (New) -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/mahajan.jpg" alt="Mr Arun O Mahajan" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Mr. Arun O Mahajan</h5>
                     <ul class="faculty-description">
                        <li class="faculty-description">BE (Mechanical)</li>
                        <li class="faculty-description" >M Tech (Thermal Power Engg.)</li>
                        <li class="faculty-description">MEO Class I (Motor)</li>
                        <li class="faculty-description">15 Years Sailing Experience at Various Ranks,
                           Including CE Rank
                        </li>
                        <li class="faculty-description">14 Years Teaching Experience, Worked as Senior
                           Associate Professor (Marine Engeering) at
                           Tolani Maritime Institute.
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

@endsection

