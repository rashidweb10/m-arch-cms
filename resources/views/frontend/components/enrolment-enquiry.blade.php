
@php 
    $categories = \App\Models\CourseCategory::where('is_active', 1)->whereIn('id', [33, 34])->get();
    $courses = \App\Models\Course::where('is_active', 1)->whereIn('category_id', [33, 34])->get();
    $user = auth()->user();
@endphp

<form style="text-align: left;" class="needs-validation" id="contactForm" action="{{route('form.submit')}}" method="POST" onsubmit="protect_with_recaptcha_v3(this, 'contact')">
    @include('frontend.components.form-alert')
    @csrf                    
    <input type="hidden" name="form_name" value="enrolments">
<!-- User Details -->
<div class="row">
    <div class="col-md-6">
        <label class="form-label robot_slab fw-bold mt-3 mb-1">Name</label>
        <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">

        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ $user->name ?? '' }}"
            {{ $user ? 'readonly' : '' }}
            required
            placeholder="Name"
        >
    </div>

    <div class="col-md-6">
        <label class="form-label robot_slab fw-bold mt-3 mb-1">Email</label>
        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ $user->email ?? '' }}"
            {{ $user ? 'readonly' : '' }}
            required
            placeholder="Email ID"
        >
    </div>

    <div class="col-md-12">
        <label class="form-label robot_slab fw-bold mt-3 mb-1">Phone</label>
        <input
            type="tel"
            name="phone"
            class="form-control"
            value="{{ $user->phone ?? '' }}"
            {{ ($user && $user->phone) ? 'readonly' : '' }}
            required
            placeholder="Enter 10-digit phone number" pattern="[0-9]{10}" maxlength="10" inputmode="numeric"
        >
    </div>
</div>                    

    <div class="row">
        <div class="col-md-12">
            <label class="form-label robot_slab fw-bold mt-3 mb-1">
                Course Type
            </label>
        </div>

        @foreach($categories as $category)
        <div class="col-md-6">
            <div class="">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="course_category"
                        id="{{ $category->id }}"
                        data-category-id="{{ $category->id }}"
                        value="{{ $category->name }}"
                        required
                    >
                    <label class="form-check-label" for="{{ $category->id }}">
                        <i class="fa-solid fa-chalkboard me-2"></i>
                        {{ $category->name }}
                    </label>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Course Select -->
    <div class="mb-4">
        <label for="courseSelect" class="form-label robot_slab fw-bold">
            Select Course:
        </label>

        <select
            class="form-select"
            id="courseSelect"
            name="course"
            required
        >
        <option value="">--Select--</option>
        @foreach($courses as $course)
            <option data-category-id="{{ $course->category_id }}" value="{{$course->name}}">{{$course->name}}</option>
        @endforeach
        </select>
    </div>

    <!-- Submit Button -->
    <div class="text-center">
        <button type="submit" class="btn btn-primary robot_slab">
            Enroll Now
        </button>
    </div>

</form>

@push('components.scripts')
<script defer>
$(document).ready(function () {

    // Hide all course options initially (except placeholder)
    $('#courseSelect option').hide();
    $('#courseSelect option:first').show();

    // When category radio changes
    $('input[name="course_category"]').on('change', function () {

        let selectedCategoryId = $(this).data('category-id');

        // Reset dropdown
        $('#courseSelect').val('');

        // Hide all options
        $('#courseSelect option').hide();

        // Show placeholder
        $('#courseSelect option:first').show();

        // Show only matching category courses
        $('#courseSelect option[data-category-id="' + selectedCategoryId + '"]').show();
    });

});
</script>
@endpush