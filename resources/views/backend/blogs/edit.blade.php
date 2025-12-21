<form id="edit" action="{{ route('blogs.update', $pageData->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">

        <!-- Title -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input value="{{ $pageData->title }}" name="title" type="text" class="form-control" minlength="3" maxlength="200" required>
            </div>
        </div>

        <!-- Slug -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                <input value="{{ $pageData->slug }}" name="slug" type="text" class="form-control" required>
            </div>
        </div>

        <!-- Excerpt -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="excerpt" class="form-label">Excerpt</label>
                <textarea name="excerpt" class="form-control" rows="3" maxlength="500">{{ $pageData->excerpt }}</textarea>
            </div>
        </div>

        <!-- Content -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control" id="content-editor" required>{{ $pageData->content }}</textarea>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="featured_image" class="form-label">Featured Image</label>
                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse') }}</div>
                    </div>
                    <div class="form-control file-amount">{{ __('Choose File') }}</div>
                    <input type="hidden" name="featured_image" class="selected-files" value="{{ $pageData->featured_image }}">
                </div>
                <div class="file-preview box sm">
                    @if($pageData->featured_image)
                        <div class="d-flex align-items-center">
                            <img src="{{ uploaded_asset($pageData->featured_image) }}" width="32" height="32" class="rounded me-2" alt="Featured Image">
                            <span>{{ basename($pageData->featured_image) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="categories" class="form-label">Categories</label>
                <select name="categories[]" class="form-select select2" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($pageData->categories->contains($category->id)) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Status -->
        <div class="col-sm-6">
            <div class="form-group mb-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft" @if($pageData->status == 'draft') selected @endif>Draft</option>
                    <option value="published" @if($pageData->status == 'published') selected @endif>Published</option>
                </select>
            </div>
        </div>

        <!-- Published At -->
        <div class="col-sm-6">
            <div class="form-group mb-2">
                <label for="published_at" class="form-label">Published At</label>
                <input value="{{ $pageData->published_at ? $pageData->published_at->format('Y-m-d\TH:i') : '' }}" name="published_at" type="datetime-local" class="form-control">
            </div>
        </div>

        <!-- Meta Title -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input value="{{ $pageData->meta_title }}" name="meta_title" type="text" class="form-control" maxlength="200">
            </div>
        </div>

        <!-- Meta Description -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="2" maxlength="300">{{ $pageData->meta_description }}</textarea>
            </div>
        </div>

        <!-- Meta Keywords -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                <input value="{{ $pageData->meta_keywords }}" name="meta_keywords" type="text" class="form-control">
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
    initSelect2('.select2');
    initTextEditor('#content-editor');

    // Auto-generate slug from title
    $('input[name="title"]').on('input', function() {
        var title = $(this).val();
        var slug = title.toLowerCase().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-');
        $('input[name="slug"]').val(slug);
    });

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