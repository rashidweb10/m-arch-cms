@extends('frontend.layouts.app')

@section('meta.title', "Blogs")
@section('meta.description', "Blogs")

@section('content')
@include('frontend.partials.breadcrumb', ['title' => "Blogs"])

<section class="pt-4 pt-md-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="mb-4">
                    <form method="GET" action="{{ route('blog.index') }}">
                        <div class="mb-3">
                            <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Search blog">
                        </div>

                        <div class="mb-3">
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" @if(request()->get('category') == $cat->slug) selected @endif>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-2 btn-success robot_slab w-100">Filter</button>
                        <a href="{{ route('blog.index') }}" class="btn btn-secondary robot_slab w-100 mt-2">Reset</a>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    @forelse($blogs as $blog)
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none text-dark">
                                <div class="classroom_box border_2 position-relative">
                                    <img class="hvr-bounce-in w-100" src="{{ uploaded_asset($blog->image) }}" alt="{{ $blog->title }}">

                                    <div class="text-center pt-3">
                                        <p class="centered-text robot_slab">{{ $blog->title }}</p>
                                    </div>
                                </div>
                            </a>

                            <div class="pt-2">
                                @php
                                    $cats = $blog->categories ? $blog->categories->pluck('name')->filter()->values() : collect();
                                @endphp
                                @if($cats->count())
                                    <small class="text-muted">{{ $cats->implode(', ') }}</small>
                                @endif

                                @if($blog->excerpt)
                                    <div class="mt-2">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($blog->excerpt), 120) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">No blogs found.</div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $blogs->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
