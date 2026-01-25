<form id="edit" action="{{ route('quizzes.update', $pageData->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Course -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                <select name="course_id" class="form-select" required>
                    <option value="">Select Course</option>
                    @foreach($courseList as $id => $name)
                        <option value="{{ $id }}" @if(old('course_id', $pageData->course_id) == $id) selected @endif>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Title -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input value="{{ old('title', $pageData->title) }}" name="title" type="text" class="form-control" minlength="3" maxlength="200" required>
            </div>
        </div>
        
        <!-- Total Marks -->
        <div class="col-sm-6">
            <div class="form-group mb-2">
                <label for="total_marks" class="form-label">Total Marks <span class="text-danger">*</span></label>
                <input value="{{ old('total_marks', $pageData->total_marks) }}" name="total_marks" type="number" class="form-control" min="1" required>
            </div>
        </div>
        
        <!-- Pass Marks -->
        <div class="col-sm-6">
            <div class="form-group mb-2">
                <label for="pass_marks" class="form-label">Pass Marks <span class="text-danger">*</span></label>
                <input value="{{ old('pass_marks', $pageData->pass_marks) }}" name="pass_marks" type="number" class="form-control" min="1" required>
            </div>
        </div>

        <!-- Is Active (dropdown) -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="is_active" class="form-label">Status</label>
                <select name="is_active" class="form-select" required>
                    <option value="1" @if(old('is_active', $pageData->is_active) == 1) selected @endif>Active</option>
                    <option value="0" @if(old('is_active', $pageData->is_active) == 0) selected @endif>Inactive</option>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-sm-12">
            <div class="text-center mt-1">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    initValidate('#edit'); // Initializes validation for the form

    $("#edit").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, callbackEditForm);
    });

    const callbackEditForm = function(response) {
        setTimeout(function() {
            location.reload(); // Reload the page after a successful form submission
        }, 1500);
    }
});
</script>
