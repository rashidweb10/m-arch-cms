@extends('frontend.layouts.app')

@section('meta')
<title>{{ $blog->seo_title }} | {{ config('app.name') }}</title>
<meta name="description" content="{{ $blog->seo_description }}">
@if($blog->seo_keywords)
<meta name="keywords" content="{{ $blog->seo_keywords }}">
@endif
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <h1>{{ $blog->title }}</h1>
        <p class="text-muted">Published on {{ $blog->published_at->format('M d, Y') }}</p>
        @if($blog->featured_image)
        <img src="{{ uploaded_asset($blog->featured_image) }}" class="img-fluid mb-4" alt="{{ $blog->title }}">
        @endif
        <div class="content">
            {!! $blog->content !!}
        </div>
        <div class="mt-4">
            <strong>Categories:</strong>
            @foreach($blog->categories as $category)
                <a href="{{ route('blog.category', $category->slug) }}" class="badge bg-secondary me-1">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h3>Related Posts</h3>
        <div class="row">
            @foreach($relatedBlogs as $related)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($related->featured_image)
                    <img src="{{ uploaded_asset($related->featured_image) }}" class="card-img-top" alt="{{ $related->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $related->title }}</h5>
                        <p class="card-text">{{ Str::limit($related->excerpt, 100) }}</p>
                        <a href="{{ route('blog.show', $related->slug) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection