<form id="create" action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Course -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                <select name="course_id" class="form-select" required>
                    <option value="">Select Course</option>
                    @foreach($courseList as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Title -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input value="" name="title" type="text" class="form-control" minlength="3" maxlength="200" required>
            </div>
        </div>
        
        <!-- Total Marks -->
        <div class="col-sm-6">
            <div class="form-group mb-2">
                <label for="total_marks" class="form-label">Total Marks <span class="text-danger">*</span></label>
                <input value="" name="total_marks" type="number" class="form-control" min="1" required>
            </div>
        </div>
        
        <!-- Pass Marks -->
        <div class="col-sm-6">
            <div class="form-group mb-2">
                <label for="pass_marks" class="form-label">Pass Marks <span class="text-danger">*</span></label>
                <input value="" name="pass_marks" type="number" class="form-control" min="1" required>
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
