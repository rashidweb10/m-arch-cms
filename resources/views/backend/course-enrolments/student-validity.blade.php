<form id="update-student-validity" action="{{ route('course-enrolments.student-validity.update', $student->id) }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-12">
            <div class="alert alert-info py-2">
                <strong>{{ $student->name }}</strong><br>
                <small>{{ $student->email }}</small>
            </div>
        </div>

        @if ($enrolments->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning mb-0">No courses are currently assigned to this student.</div>
            </div>
        @else
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Assigned courses <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="select-all-enrolments">
                        <label class="form-check-label" for="select-all-enrolments">Select all</label>
                    </div>
                </div>
                <input type="search" id="enrolment-search" class="form-control mb-2" placeholder="Search assigned courses..." autocomplete="off">
                <div class="border rounded p-2 mb-3" style="max-height: 300px; overflow-y: auto;">
                    @foreach ($enrolments as $enrolment)
                        <div class="form-check enrolment-item py-1">
                            <input class="form-check-input enrolment-checkbox" type="checkbox" name="enrolment_ids[]" value="{{ $enrolment->id }}" id="enrolment_{{ $enrolment->id }}">
                            <label class="form-check-label" for="enrolment_{{ $enrolment->id }}">
                                {{ $enrolment->course->name ?? 'Course unavailable' }}
                                @if ($enrolment->course?->category)
                                    <span class="text-muted">({{ $enrolment->course->category->name }})</span>
                                @endif
                                <small class="d-block text-muted">Current validity: {{ $enrolment->validity ? formatDate($enrolment->validity) : 'Not set' }}</small>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                <div class="form-group mb-3">
                    <label for="student_validity" class="form-label">New validity date <span class="text-danger">*</span></label>
                    <input type="date" name="validity" id="student_validity" class="form-control" min="{{ now()->toDateString() }}" required>
                </div>
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Update selected courses</button>
            </div>
        @endif
    </div>
</form>

<script>
$(function () {
    $('#select-all-enrolments').on('change', function () {
        $('.enrolment-checkbox:visible').prop('checked', this.checked);
    });

    $('#enrolment-search').on('input', function () {
        const search = $(this).val().trim().toLowerCase();
        $('.enrolment-item').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(search));
        });
    });

    $('#update-student-validity').on('submit', function (event) {
        if ($('.enrolment-checkbox:checked').length === 0) {
            event.preventDefault();
            toastr.error('Please select at least one assigned course.');
            return;
        }

        ajaxSubmit(event, $(this), function (response) {
            if (response && response.status) {
                $('#largeModal').modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }
        });
    });
});
</script>
