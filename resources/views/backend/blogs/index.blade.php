@extends('backend.layouts.app')

@section('content')
<div class="page-title-head d-flex align-items-center gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-16 text-uppercase fw-bold mb-0">{{$moduleName}}</h4>
    </div>
</div>
@include('backend.includes.alert-message')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header border-bottom border-dashed align-items-center">
                <div class="row">
                    <div class="col-md-10">
                        <form class="row g-3 align-items-center">
                            <div class="col-md">
                                <select name="status" class="form-select select2" id="status-select">
                                    <option value="" selected>All Status</option>
                                    <option value="published" @if(request()->get('status') == 'published') selected @endif>Published</option>
                                    <option value="draft" @if(request()->get('status') == 'draft') selected @endif>Draft</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <input type="text" name="search" class="form-control" value="{{request()->get('search')}}" placeholder="Search by title, slug, excerpt, content">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success btn-icon w-100">
                                    <i class="ti ti-search"></i>
                                </button>
                            </div>
                            <div class="col-md-1">
                                <button type="reset" class="btn btn-warning btn-icon w-100"
                                    onclick="window.location.href = '{{ route(Route::currentRouteName()) }}';">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2 text-end">
                        <button onclick="smallModal('{{url(route('blogs.create'))}}', 'Add New')"
                        class="btn btn-primary btn-icon w-100"><i class="ti ti-plus"></i> Add New</button>
                    </div>
                </div>
                <div class="row mt-3" id="bulkActionsContainer" style="display: none;">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted" id="selectedCount">0 items selected</span>
                            <button type="button" class="btn btn-xs btn-danger" onclick="bulkDeleteBlogs()">
                                <i class="ti ti-trash"></i> Delete
                            </button>
                            <button type="button" class="btn btn-xs btn-success" onclick="bulkPublishBlogs()">
                                <i class="ti ti-check"></i> Publish
                            </button>
                            <button type="button" class="btn btn-xs btn-warning" onclick="bulkDraftBlogs()">
                                <i class="ti ti-x"></i> Draft
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll()" style="cursor: pointer; width: 1.2em; height: 1.2em; margin-top: 0.25em;">
                                    </div>
                                </th>
                                <th>#</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Categories</th>
                                <th>Status</th>
                                <th>Published At</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pageData as $index => $row)
                            <tr>
                                <td class="text-center">
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input row-checkbox" type="checkbox" value="{{ $row->id }}" onchange="updateBulkActions()" style="cursor: pointer; width: 1.2em; height: 1.2em; margin-top: 0.25em;">
                                    </div>
                                </td>
                                <td>{{ $pageData->firstItem() + $index }}</td>
                                <td>{{ $row->title }}</td>
                                <td>{{ $row->slug }}</td>
                                <td>
                                    @foreach($row->categories as $category)
                                        <span class="badge bg-secondary">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                <span class="badge {{ $row->status == 'published' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($row->status) }}
                                </span>
                                </td>
                                <td>{{ $row->published_at ? formatDatetime($row->published_at) : 'N/A' }}</td>
                                <td>{{ formatDatetime($row->created_at) }}</td>
                                <td>
                                    <a href="javascript:void(0);" onclick="smallModal('{{url(route('blogs.edit', $row->id))}}', 'Edit')" class="link-reset fs-20 p-1"> <i class="ti ti-pencil"></i></a>
                                    <a href="javascript:void(0);" onclick="confirmModal('{{ route('blogs.destroy', $row->id) }}', callbackBlogs )" class="link-reset fs-20 p-1"> <i class="ti ti-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pageData->appends(request()->input())->links() }}
                </div> <!-- end table-responsive-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div><!-- end row-->

<script defer>
const callbackBlogs = function(response) {
    setTimeout(function() {
        location.reload();
    }, 1500);
}

// Bulk actions functions
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const selectedCount = checkboxes.length;
    const bulkActionsContainer = document.getElementById('bulkActionsContainer');
    const selectedCountSpan = document.getElementById('selectedCount');

    if (selectedCount > 0) {
        bulkActionsContainer.style.display = 'block';
        selectedCountSpan.textContent = selectedCount + ' item(s) selected';
    } else {
        bulkActionsContainer.style.display = 'none';
    }

    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    const selectAll = document.getElementById('selectAll');
    if (allCheckboxes.length > 0) {
        selectAll.checked = selectedCount === allCheckboxes.length;
    }
}

function getSelectedIds() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const ids = Array.from(checkboxes).map(checkbox => checkbox.value);
    return ids;
}

function bulkDeleteBlogs() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        toastr.error('Please select at least one item');
        return;
    }

    const message = 'Are you sure you want to delete ' + ids.length + ' selected item(s)?';
    document.getElementById('bulk_delete_message').textContent = message;
    document.getElementById('bulk_delete_ids').value = ids.join(',');
    document.getElementById('bulk_delete_form').setAttribute('action', '{{ route("blogs.bulk-delete") }}');
    callBackFunction = callbackBulkBlogs;
    $('#bulkDeleteModal').modal('show');
}

function bulkPublishBlogs() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        toastr.error('Please select at least one item');
        return;
    }

    const message = 'Are you sure you want to publish ' + ids.length + ' selected item(s)?';
    document.getElementById('bulk_publish_message').textContent = message;
    document.getElementById('bulk_publish_ids').value = ids.join(',');
    document.getElementById('bulk_publish_form').setAttribute('action', '{{ route("blogs.bulk-publish") }}');
    callBackFunction = callbackBulkBlogs;
    $('#bulkPublishModal').modal('show');
}

function bulkDraftBlogs() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        toastr.error('Please select at least one item');
        return;
    }

    const message = 'Are you sure you want to draft ' + ids.length + ' selected item(s)?';
    document.getElementById('bulk_draft_message').textContent = message;
    document.getElementById('bulk_draft_ids').value = ids.join(',');
    document.getElementById('bulk_draft_form').setAttribute('action', '{{ route("blogs.bulk-draft") }}');
    callBackFunction = callbackBulkBlogs;
    $('#bulkDraftModal').modal('show');
}

// Callback function for bulk actions
const callbackBulkBlogs = function(response) {
    // Close all bulk modals
    $('#bulkDeleteModal').modal('hide');
    $('#bulkPublishModal').modal('hide');
    $('#bulkDraftModal').modal('hide');

    // Only reload on success
    if (response && response.status) {
        setTimeout(function() {
            location.reload();
        }, 1500);
    }
}
</script>
@endsection