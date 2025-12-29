@extends('frontend.layouts.profile')

@section('meta.title', $course->name)
@section('meta.description', "Syllabus and materials for " . $course->name)

@php
    $pageTitle = $course->name;
@endphp

@section('profile-content')
<div class="bg-light p-4 p-md-5 rounded-3 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold robot_slab">{{ $course->name }}</h3>
        <a href="{{ route('auth.enrolled-courses') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Enrolled Courses
        </a>
    </div>

    <div class="text-muted mb-4">
        <strong>Category:</strong> {{ $course->category->name ?? 'N/A' }}
    </div>

    @if($course->materials->count() > 0)
        <div class="accordion" id="courseMaterialsAccordion">
            @foreach($course->materials as $index => $material)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ $index }}">
                        <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $index }}">
                            <strong>{{ $material->title }}</strong>
                        </button>
                    </h2>
                    <div id="collapse-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $index }}" data-bs-parent="#courseMaterialsAccordion">
                        <div class="accordion-body">
                            <p>{{ $material->description }}</p>

                            {{-- @if($material->file_path)
                                <a href="{{ asset('storage/' . $material->file_path) }}" class="btn btn-primary btn-sm" target="_blank">
                                    <i class="fas fa-download me-2"></i>Download Material
                                </a>
                            @endif

                             @if($material->video_url)
                                <a href="{{ $material->video_url }}" class="btn btn-secondary btn-sm" target="_blank">
                                    <i class="fas fa-video me-2"></i>Watch Video
                                </a>
                            @endif --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted">No materials available for this course yet.</p>
        </div>
    @endif
</div>
@endsection
