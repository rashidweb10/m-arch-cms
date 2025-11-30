<form id="create" action="{{ route('course-materials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <!-- Course -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                <select name="course_id" class="form-select select2" required>
                    <option value="">--Select--</option>
                    @foreach ($courseList as $index => $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
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
        
        <!-- Description -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Enter description"></textarea>
            </div>
        </div>

        <!-- Attachments -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="attachments" class="form-label">Attachments</label>
                <div class="input-group" data-toggle="aizuploader" data-type="document" data-multiple="true">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse') }}</div>
                    </div>
                    <div class="form-control file-amount">{{ __('Choose File') }}</div>
                    <input type="hidden" name="attachments" class="selected-files">
                </div>
                <div class="file-preview box sm"></div>
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
    initTextEditor();
    initSelect2('.select2');

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

