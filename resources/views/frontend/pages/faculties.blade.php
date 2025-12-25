@extends('frontend.layouts.app')

@section('meta.title', $pageData->seo_title)
@section('meta.description', $pageData->seo_description)

@section('content')

@php
  $about_title = $pageData->meta->where('meta_key', 'about_title')->first()->meta_value ?? '';
  $about_description = $pageData->meta->where('meta_key', 'about_description')->first()->meta_value ?? '';
  $faculties = json_decode($pageData->meta->where('meta_key', 'faculty')->first()->meta_value ?? '[]', true);
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
      @if(isset($faculties['itration']) && is_array($faculties['itration']))
      <div class="row g-5">

      @foreach($faculties['itration'] as $index => $itration)
      <div class="col-lg-6 mb-4">
         <div class="card faculty-card p-4">
            <div class="d-flex align-items-start gap-3">

            <img
               src="{{ uploaded_asset($faculties['image'][$index]) }}"
               alt="{{ $faculties['name'][$index] ?? 'Faculty' }}"
               class="faculty-image"
            />

            <div>
               <h5 class="faculty-name mb-1 robot_slab">
                  {{ $faculties['name'][$index] ?? '' }}
               </h5>

               <p class="faculty-description">
                  {!! nl2br(e($faculties['description'][$index] ?? '')) !!}
               </p>
            </div>

            </div>
         </div>
      </div>
      @endforeach


      </div>
      @endif
   </div>
</section>

@endsection

