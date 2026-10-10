@extends('backend.layouts.app')

@section('content')
<div class="page-title-head d-flex align-items-center gap-2 mb-3">
    <div class="flex-grow-1">
        <h4 class="fs-16 text-uppercase fw-bold mb-0">Bulk Assign Courses</h4>
    </div>
    <a href="{{ route('course-enrolments.index') }}" class="btn btn-outline-secondary">Back to Enrolments</a>
</div>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="alert alert-warning">
            Assigning these courses will replace any existing assignment for the selected student and course. Other course assignments will not be changed.
        </div>

        <form id="bulk-course-assignment" action="{{ route('course-enrolments.bulk-assign.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">
                            Students <span class="text-danger">*</span>
                            <span class="badge bg-light text-dark ms-1" id="selected-student-count" aria-live="polite">0 selected</span>
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all-students">
                            <label class="form-check-label" for="select-all-students">Select visible</label>
                        </div>
                    </div>
                    <input type="search" id="student-search" class="form-control mb-2" placeholder="Search students..." autocomplete="off">
                    <div class="border rounded p-2" style="max-height: 320px; overflow-y: auto;">
                        @forelse ($students as $student)
                            <div class="form-check student-item py-1">
                                <input
                                    class="form-check-input student-checkbox"
                                    type="checkbox"
                                    name="student_ids[]"
                                    value="{{ $student->id }}"
                                    id="bulk_student_{{ $student->id }}"
                                    @checked(in_array($student->id, old('student_ids', [])))
                                >
                                <label class="form-check-label" for="bulk_student_{{ $student->id }}">
                                    {{ $student->name }} <span class="text-muted">({{ $student->email }})</span>
                                </label>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No students are available.</p>
                        @endforelse
                    </div>
                    @error('student_ids') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    @error('student_ids.*') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="mb-3">
                        <label for="bulk-category" class="form-label">Course category <span class="text-danger">*</span></label>
                        <select name="category_id" id="bulk-category" class="form-select select2" required>
                            <option value="">Select one category</option>
                            @foreach ($categoryList as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">
                            Courses <span class="text-danger">*</span>
                            <span class="badge bg-light text-dark ms-1" id="selected-course-count" aria-live="polite">0 selected</span>
                        </label>
                        <div class="form-check" id="select-all-courses-wrapper" hidden>
                            <input class="form-check-input" type="checkbox" id="select-all-courses">
                            <label class="form-check-label" for="select-all-courses">Select visible</label>
                        </div>
                    </div>
                    <input type="search" id="course-search" class="form-control mb-2" placeholder="Search courses..." autocomplete="off" hidden>
                    <div id="bulk-courses" class="border rounded p-2" style="max-height: 320px; overflow-y: auto;" aria-live="polite">
                        <p class="text-muted mb-0">Choose a category to load its courses.</p>
                    </div>
                    @error('course_ids') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    @error('course_ids.*') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="bulk-validity" class="form-label">Validity date</label>
                    <input type="date" name="validity" id="bulk-validity" class="form-control" value="{{ old('validity') }}">
                    @error('validity') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bulk-status" class="form-label">Assignment status <span class="text-danger">*</span></label>
                    <select name="is_active" id="bulk-status" class="form-select" required>
                        <option value="1" @selected(old('is_active', '1') == '1')>Active</option>
                        <option value="0" @selected(old('is_active') === '0')>Inactive</option>
                    </select>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Assign selected courses</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(function () {
    const previouslySelectedCourses = new Set(@json(array_map('strval', old('course_ids', []))));
    let courseRequestId = 0;

    function updateSelectionCounts() {
        $('#selected-student-count').text($('.student-checkbox:checked').length + ' selected');
        $('#selected-course-count').text($('.bulk-course-checkbox:checked').length + ' selected');
    }

    $(document).on('change', '.student-checkbox', updateSelectionCounts);

    $('#student-search').on('input', function () {
        const search = $(this).val().trim().toLowerCase();
        $('.student-item').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(search));
        });
        $('#select-all-students').prop('checked', false);
    });

    $('#select-all-students').on('change', function () {
        $('.student-item:visible .student-checkbox').prop('checked', this.checked).trigger('change');
    });

    $('#bulk-category').on('change', function () {
        loadCategoryCourses();
    });

    $('#course-search').on('input', function () {
        const search = $(this).val().trim().toLowerCase();
        $('.bulk-course-item').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(search));
        });
        $('#select-all-courses').prop('checked', false);
    });

    $('#select-all-courses').on('change', function () {
        $('.bulk-course-item:visible .bulk-course-checkbox').prop('checked', this.checked).trigger('change');
    });

    $(document).on('change', '.bulk-course-checkbox', function () {
        updateCourseSelection(this);
        updateSelectionCounts();
    });

    $('#bulk-course-assignment').on('submit', function (event) {
        if ($('.student-checkbox:checked').length === 0) {
            event.preventDefault();
            toastr.error('Please select at least one student.');
            return;
        }

        if ($('.bulk-course-checkbox:checked').length === 0) {
            event.preventDefault();
            toastr.error('Please select at least one course.');
        }
    });

    function loadCategoryCourses() {
        const requestId = ++courseRequestId;
        const categoryId = $('#bulk-category').val();
        const $container = $('#bulk-courses');
        const $selectAll = $('#select-all-courses-wrapper');
        const $search = $('#course-search');

        $selectAll.prop('hidden', true);
        $search.prop('hidden', true).val('');

        if (!categoryId) {
            $container.html('<p class="text-muted mb-0">Choose a category to load its courses.</p>');
            updateSelectionCounts();
            return;
        }

        $container.html('<p class="text-muted mb-0">Loading courses...</p>');
        updateSelectionCounts();
        $.ajax({
            url: @json(route('courses.by-category')),
            method: 'GET',
            data: { category_id: categoryId },
            success: function (courses) {
                if (requestId !== courseRequestId) {
                    return;
                }

                $container.empty();
                if (!Array.isArray(courses) || courses.length === 0) {
                    $container.html('<p class="text-muted mb-0">No active courses are available in this category.</p>');
                    return;
                }

                courses.forEach(function (course) {
                    const id = String(course.id);
                    const checkboxId = 'bulk_course_' + id;
                    const $item = $('<div>', { class: 'form-check bulk-course-item py-1' });
                    const $checkbox = $('<input>', {
                        class: 'form-check-input bulk-course-checkbox',
                        type: 'checkbox',
                        name: 'course_ids[]',
                        value: id,
                        id: checkboxId,
                        checked: previouslySelectedCourses.has(id)
                    });
                    const $label = $('<label>', {
                        class: 'form-check-label',
                        for: checkboxId
                    }).text(course.name);

                    $item.append($checkbox, $label);
                    $container.append($item);
                });

                $selectAll.prop('hidden', false);
                $search.prop('hidden', false);
                updateSelectionCounts();
            },
            error: function () {
                if (requestId === courseRequestId) {
                    $container.html('<p class="text-danger mb-0">Could not load courses. Please change the category or reload the page.</p>');
                    updateSelectionCounts();
                }
            }
        });
    }

    function updateCourseSelection(checkbox) {
        const courseId = String(checkbox.value);
        if (checkbox.checked) {
            previouslySelectedCourses.add(courseId);
        } else {
            previouslySelectedCourses.delete(courseId);
        }
    }

    updateSelectionCounts();

    if ($('#bulk-category').val()) {
        loadCategoryCourses();
    }
});
</script>
@endsection
