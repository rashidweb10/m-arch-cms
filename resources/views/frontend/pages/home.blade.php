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


<div class="banner_slider">
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <!-- Carousel items -->
    <div class="carousel-inner">
    @foreach($banner_images as $index => $id)
      <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
        <img src="{{ uploaded_asset($id) }}" class="d-block w-100" alt="Slide {{ $index + 1 }}">
      </div>
    @endforeach
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>


<div class="wave_img">
  <img class="w-100" src="{{ asset('assets/frontend/img/wave.png') }}" alt="img" />
</div>


<!--about us section start-->
<section class="about-us pt-4 pt-md-5 pb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 ps-md-4 order-md-1 order-2" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
        <div class="text-start mb-md-4 mb-2">
          <h3 class="robot_slab text_color font-wight-400">{{$about_title}}</h3>
        </div>
     
        
        {!! $about_description !!}


        <div class="read-more">
          <a href="{{url('/about-us')}}" class="btn-2">Explore</a>
        </div>
      </div>
      <div class="col-lg-4 col-lg-4 ps-md-5 order-1" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
        <div class="about_imgs_1 text-center">
          <img class="hvr-bounce-in" src="{{ uploaded_asset($about_image) }}" alt="img" />
        </div>
      </div>
    </div>
  </div>
</section>


<section class="industries_section">
  <div class=" pb-4 pt-4 pb-md-5 pt-md-5">   
    <div class="container">
      <div class=" mb-md-4 mb-2 text-center" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
        <h3 class="robot_slab text_color font-wight-400">{{$industries_title}}</h3>
        <p class="text-center ps-md-5 pe-md-5">{!! $industries_description !!}</p>
      </div>
      <div class="row">
        @if(isset($industries['itration']) && is_array($industries['itration']))
            @foreach($industries['itration'] as $index => $itration)          
        <div class="col-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
          <div class="industries_box position-relative">
            <div class="">
              <img class="hvr-bounce-in" src="{{ uploaded_asset($industries['image'][$index]) }}" alt="Image 1">
              <div class="industries_content text-center">
                <p class="centered-text">{{ $industries['title'][$index] ?? '' }}</p>
              </div>
            </div>
          </div>
        </div>
            @endforeach
        @endif
      </div>
    </div>
  </div>
</section> 

@endsection
