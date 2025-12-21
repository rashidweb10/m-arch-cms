@extends('frontend.layouts.app')

@section('meta')
<title>Blog | {{ config('app.name') }}</title>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Blog</h1>
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