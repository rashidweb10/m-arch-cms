@extends('frontend.layouts.app')

@section('meta.title', $pageData->seo_title)
@section('meta.description', $pageData->seo_description)

@section('content')

@include('frontend.partials.breadcrumb', ['title' => $pageData->title, 'image' => $pageData->meta->where('meta_key', 'banner_images')->first()->meta_value ?? ''])
@php
    //$testimonial_images = array_filter(explode(',', $pageData->testimonial_images ?? ''));
    $testimonial_images = array_filter(explode(',', $pageData->meta->where('meta_key', 'testimonial_images')->first()->meta_value ?? ''));

@endphp
<section class="courses_we_offered pt-4 pt-md-5 pb-4 position-relative" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-12 aos-init aos-animate" >
            <div class="text-start mb-md-4 mb-2 pt-2">
               <h3 class=" text_color text-center robot_slab ">{{$pageData->title}}</h3>
            </div>
         </div>
         <div class="row">
            @foreach($testimonial_images as $img)
            <div class="col-md-3">
               <div class="position-relative">
                  <div class="testiminials_box">
                     <a data-fancybox="gallery" data-caption="IMU CET Entrance" href="{{ uploaded_asset($img) }}">
                     <img src="{{ uploaded_asset($img) }}" class=" " alt="IMU CET Entrance">
                     </a>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</section>
@endsection

