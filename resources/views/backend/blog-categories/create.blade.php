<form id="create" action="{{ route('blog-categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <!-- Name -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input value="" name="name" type="text" class="form-control" minlength="3" maxlength="200" required>
            </div>
        </div>

        <!-- Slug -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                <input value="" name="slug" type="text" class="form-control" required>
            </div>
        </div>

        <!-- Parent Category -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select name="parent_id" class="form-select select2">
                    <option value="">Select Parent</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Description -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description-editor" rows="3"></textarea>
            </div>
        </div>

        <!-- Meta Title -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input value="" name="meta_title" type="text" class="form-control" maxlength="200">
            </div>
        </div>

        <!-- Meta Description -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="2" maxlength="300"></textarea>
            </div>
        </div>

        <!-- Meta Keywords -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                <input value="" name="meta_keywords" type="text" class="form-control">
            </div>
        </div>

        <!-- Status -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
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
    initTextEditor('#description-editor');

    // Auto-generate slug from name
    $('input[name="name"]').on('input', function() {
        var name = $(this).val();
        var slug = name.toLowerCase().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-');
        $('input[name="slug"]').val(slug);
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