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
        <div class="mb-3">
            <button class="btn btn-sm btn-primary" id="toggle-accordion" style1="float: right;position: relative;top: -50px;">
                Expand All
            </button>
        </div>
        <div class="accordion" id="courseMaterialsAccordion">
            @foreach($course->materials as $index => $material)
                @php 
                    $attachments = array_filter(explode(',', $material->attachments ?? ''));
                @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="false" aria-controls="collapse-{{ $index }}">
                            <strong>{{ $index + 1 }}.  {{ $material->title }}</strong>
                        </button>
                    </h2>
                    <div id="collapse-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $index }}" data-bs-parent="#courseMaterialsAccordion">
                        <div class="accordion-body">
                            @if($material->description)
                            <p class="mb-0"><strong>Description:</strong></p>
                            <p>{{ $material->description }}</p>
                            @endif

                            @if($attachments)
                               <p class="mb-0"><strong>Attachments:</strong></p>
                                @foreach($attachments as $index => $id)
                                    @php
                                        $url  = uploaded_asset($id);
                                        $name = uploaded_asset_name($id);
                                        $type = uploaded_asset_type($id); // image | pdf | doc | etc
                                    @endphp

                                    <div class="attachment-item mb-2">
                                        @if($type === 'image')
                                            <!-- IMAGE THUMBNAIL -->
                                            <div class="small mt-1">{{ $index + 1 }}. {{ $name }}</div>
                                            <a href="{{ $url }}" target="_blank">
                                            <img src="{{ $url }}" class="img-thumbnail" alt="{{ $name }}" width="150">
                                            </a>
                                        @else
                                            <!-- DOCUMENT BLOCK -->
                                            <a href="{{ $url }}" target="_blank">
                                            <img src="{{ asset("assets/frontend/img/doc.png") }}" class="img-thumbnail" alt="{{ $name }}" width="150">
                                            </a>
                                            <div class="small mt-1">{{ $index + 1 }}. {{ $name }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif 

                            @if($material->youtube_url)
                            <p class="mb-0"><strong>Video:</strong></p>
                            <div class="video-wrapper">
                            <iframe
                                src="{{$material->youtube_url}}?rel=0&modestbranding=1&playsinline=1"
                                title="Demo Background Sample Video"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                            </div>
                            @endif                            
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

@section('scripts')
<script>
$(document).ready(function () {
    const $toggleButton = $('#toggle-accordion');
    const $accordionItems = $('.accordion-collapse');
    const $accordionButtons = $('.accordion-button');

    // Set initial state for all accordions to be collapsed
    $accordionItems.removeClass('show');
    $accordionButtons.addClass('collapsed').attr('aria-expanded', 'false');

    $toggleButton.on('click', function () {
        const isAnyOpen = $accordionItems.hasClass('show');

        if (isAnyOpen) {
            // Collapse All
            $accordionItems.removeClass('show');
            $accordionButtons.addClass('collapsed').attr('aria-expanded', 'false');
            $toggleButton.text('Expand All');
        } else {
            // Expand All
            $accordionItems.addClass('show');
            $accordionButtons.removeClass('collapsed').attr('aria-expanded', 'true');
            $toggleButton.text('Collapse All');
        }
    });
});
</script>
@endsection
