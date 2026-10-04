@extends('frontend.layouts.profile')

@section('meta.title', 'My Course Categories')
@section('meta.description', 'Browse your enrolled course categories')

@php
    $pageTitle = 'My Course Categories';
@endphp

@section('profile-content')
<div class="enrolled-categories">
    <div class="category-page-header mb-4">
        <div>
            <h3 class="robot_slab mb-2">My Course Categories</h3>
            <p class="mb-0">Choose a category to find the courses available to you.</p>
        </div>
        <span class="category-total">
            <i class="fas fa-folder-open me-2" aria-hidden="true"></i>
            {{ $categories->total() }} {{ \Illuminate\Support\Str::plural('category', $categories->total()) }}
        </span>
    </div>

    <form method="GET" action="{{ route('auth.enrolled-categories') }}" class="category-search mb-4">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search" aria-hidden="true"></i></span>
            <input
                type="search"
                name="search"
                class="form-control"
                value="{{ $search }}"
                placeholder="Search your categories"
                aria-label="Search your course categories"
            >
            <button class="btn btn-primary" type="submit">Search</button>
            @if ($search !== '')
                <a class="btn btn-outline-secondary" href="{{ route('auth.enrolled-categories') }}">Clear</a>
            @endif
        </div>
    </form>

    @if ($categories->isNotEmpty())
        <div class="row g-3">
            @foreach ($categories as $category)
                <div class="col-sm-6 col-xl-4">
                    <a
                        href="{{ route('auth.enrolled-courses', ['category_id' => $category->id]) }}"
                        class="category-card h-100"
                    >
                        <div class="category-card-image">
                            @if ($category->image)
                                <img src="{{ uploaded_asset($category->image) }}" alt="">
                            @else
                                <img src="{{ asset('assets/frontend/img/default.png') }}" alt="">
                            @endif
                        </div>
                        <div class="category-card-content">
                            <h4 class="robot_slab">{{ $category->name }}</h4>
                            @if ($category->description)
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($category->description), 90) }}</p>
                            @else
                                <p>Browse your courses in this category.</p>
                            @endif
                            <span class="category-card-footer">
                                {{ $category->enrolled_courses_count }}
                                {{ \Illuminate\Support\Str::plural('course', $category->enrolled_courses_count) }}
                                <span>View courses <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></span>
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        @if ($categories->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        @endif
    @else
        <div class="category-empty-state text-center">
            <span class="category-empty-icon"><i class="fas fa-folder-open" aria-hidden="true"></i></span>
            <h4 class="robot_slab">
                {{ $search !== '' ? 'No matching categories' : 'No enrolled categories yet' }}
            </h4>
            <p class="text-muted mb-3">
                {{ $search !== '' ? 'Try another search term.' : 'Your enrolled course categories will appear here.' }}
            </p>
            @if ($search !== '')
                <a href="{{ route('auth.enrolled-categories') }}" class="btn btn-outline-primary">Clear search</a>
            @endif
        </div>
    @endif
</div>

<style>
    .enrolled-categories {
        --category-blue: #147eae;
        --category-ink: #18364a;
        --category-muted: #6c7b86;
    }

    .category-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .category-page-header h3 {
        color: var(--category-ink);
    }

    .category-page-header p {
        color: var(--category-muted);
    }

    .category-total {
        flex: 0 0 auto;
        padding: 8px 12px;
        color: var(--category-blue);
        background: #e8f5fb;
        border-radius: 20px;
        font-size: .88rem;
        font-weight: 600;
    }

    .category-search .input-group-text {
        color: var(--category-muted);
        background: #fff;
    }

    .category-search .form-control:focus {
        border-color: #83c5e3;
        box-shadow: 0 0 0 .2rem rgba(20, 126, 174, .12);
    }

    .category-card {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 18px;
        color: inherit;
        background: #fff;
        border: 1px solid #e5edf1;
        border-radius: 13px;
        box-shadow: 0 4px 14px rgba(24, 54, 74, .04);
        text-decoration: none;
        transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .category-card:hover,
    .category-card:focus-visible {
        color: inherit;
        border-color: #9ed2e8;
        box-shadow: 0 9px 22px rgba(24, 94, 127, .11);
        transform: translateY(-2px);
    }

    .category-card-image {
        display: flex;
        flex: 0 0 54px;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        overflow: hidden;
        color: var(--category-blue);
        background: #e8f5fb;
        border-radius: 12px;
        font-size: 1.35rem;
    }

    .category-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-card-content {
        min-width: 0;
        flex: 1;
    }

    .category-card-content h4 {
        margin: 2px 0 6px;
        color: var(--category-ink);
        font-size: 1rem;
        font-weight: 700;
    }

    .category-card-content p {
        min-height: 2.5em;
        margin-bottom: 12px;
        color: var(--category-muted);
        font-size: .87rem;
        line-height: 1.5;
    }

    .category-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        color: var(--category-muted);
        font-size: .82rem;
    }

    .category-card-footer span {
        color: var(--category-blue);
        font-weight: 600;
        white-space: nowrap;
    }

    .category-empty-state {
        padding: 50px 20px;
        background: #fff;
        border: 1px solid #e5edf1;
        border-radius: 13px;
    }

    .category-empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        margin-bottom: 14px;
        color: var(--category-blue);
        background: #e8f5fb;
        border-radius: 14px;
        font-size: 1.4rem;
    }

    .category-empty-state h4 {
        color: var(--category-ink);
        font-size: 1.15rem;
    }

    @media (max-width: 575.98px) {
        .category-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .category-search .input-group {
            flex-wrap: wrap;
        }

        .category-search .form-control {
            min-width: 0;
        }
    }
</style>
@endsection
