@extends('frontend.layouts.app')

@section('meta')
<title>{{ $category->seo_title }} | {{ config('app.name') }}</title>
<meta name="description" content="{{ $category->seo_description }}">
@if($category->seo_keywords)
<meta name="keywords" content="{{ $category->seo_keywords }}">
@endif
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <h1>{{ $category->name }}</h1>
        @if($category->description)
        <p>{{ $category->description }}</p>
        @endif
        <div class="row">
            @foreach($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($blog->featured_image)
                    <img src="{{ uploaded_asset($blog->featured_image) }}" class="card-img-top" alt="{{ $blog->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ Str::limit($blog->excerpt, 100) }}</p>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $blogs->links() }}
    </div>
</section>
@endsection