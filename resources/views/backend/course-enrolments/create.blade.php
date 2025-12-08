<form id="create" action="{{ route('course-enrolments.store') }}" method="POST">
    @csrf
    <div class="row">

        <!-- Student (User with role_id = 3) -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="user_id" class="form-label">Student <span class="text-danger">*</span></label>
                <select name="user_id" id="user_id" class="form-select select2" required>
                    <option value="">--Select Student--</option>
                    @foreach ($students as $index => $row)
                        <option value="{{ $row->id }}">{{ $row->name }} ({{ $row->email }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Category -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="category_id" class="form-label">Course Category <span class="text-danger">*</span></label>
                <select name="category_id" id="category_id" class="form-select select2" required>
                    <option value="">--Select Category--</option>
                    @foreach ($categoryList as $index => $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Course -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                <select name="course_id" id="course_id" class="form-select select2" required>
                    <option value="">--Select Course--</option>
                </select>
            </div>
        </div>

        <!-- Validity -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="validity" class="form-label">Validity <span class="text-danger">*</span></label>
                <input value="" name="validity" type="date" class="form-control" required>
            </div>
        </div>

        <!-- Is Active (dropdown) -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="is_active" class="form-label">Status</label>
                <select name="is_active" class="form-select" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-sm-12">
            <div class="text-center mt-1">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    initValidate('#create'); // Initializes validation for the form
    initSelect2('.select2');

    // When category changes, fetch courses for that category via AJAX
    $('#category_id').on('change', function () {
        const categoryId = $(this).val();
        const $courseSelect = $('#course_id');
        const currentCourseId = $courseSelect.val();

        // Show a temporary loading option
        $courseSelect.html('<option value="">Loading...</option>');

        $.ajax({
            url: '{{ route('courses.by-category') }}',
            method: 'GET',
            data: {
                category_id: categoryId
            },
            success: function (response) {
                // Reset options
                let options = '<option value="">--Select Course--</option>';

                if (Array.isArray(response) && response.length) {
                    response.forEach(function (course) {
                        options += '<option value="' + course.id + '">' + course.name + '</option>';
                    });
                }

                $courseSelect.html(options).trigger('change.select2');
            },
            error: function () {
                // On error, just reset to default option
                $courseSelect.html('<option value="">--Select Course--</option>').trigger('change.select2');
            }
        });
    });

    $("#create").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, callbackCreateForm);
    });

    const callbackCreateForm = function(response) {
        setTimeout(function() {
            location.reload(); // Reload the page after a successful form submission
        }, 1500);
    }
});
</script>

