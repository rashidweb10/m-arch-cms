@extends('frontend.layouts.app')

@section('meta.title', 'Contact Us')
@section('meta.description', 'Contact Us')

@section('content')

@include('frontend.partials.breadcrumb', ['title' => "Courses"])

@foreach($courseCategories as $index => $category)
   <section class="courses_section pb-5 pt-5">
      <div class="container">
         <div class="row g-4 align-items-center @if($index % 2 == 1) flex-lg-row-reverse @endif">
            <div class="col-lg-6 position-relative" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
               <div class="position-relative">
                  <img src="{{ uploaded_asset($category->image) }}"
                     alt="{{ $category->name }} training" class="hvr-bounce-in w-100 course-card-img">
                  <div class="position-absolute top-3 start-3">
                     <span class="badge bg-primary text-white badge-count">{{ $category->courses_count }} Courses</span>
                  </div>
               </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
               <h3 class=" robot_slab">{{ $category->name }}</h3>
               <p>{!! $category->description !!}</p>
            </div>
         </div>
      </div>
   </section>
@endforeach
@endsection

