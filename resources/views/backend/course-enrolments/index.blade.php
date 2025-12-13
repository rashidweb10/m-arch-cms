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
                    <div class="col-md-2 mb-2">
                        <div class="dropdown">
                            <button class="btn border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="bulk-action-btn" disabled>
                                Bulk Action
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="showBulkDeleteModal()">
                                        Delete Selection
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="showBulkActiveModal()">
                                        Mark as Active
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="showBulkInactiveModal()">
                                        Mark as Inactive
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <form class="row g-3 align-items-center">
                            <div class="col-md">
                                <select name="category" class="form-select select2" id="category-select">
                                    <option value="" selected>All Categories</option>
                                    @if(isset($categoryList))
                                        @foreach ($categoryList as $index => $row)
                                            <option value="{{ $row->id }}" 
                                                @if(request()->get('category') == $row->id) selected @endif>
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md">
                                <select name="course" class="form-select select2" id="course-select">
                                    <option value="" selected>All Courses</option>
                                    @if(isset($courseList) && request()->get('category'))
                                        @foreach ($courseList as $index => $row)
                                            <option value="{{ $row->id }}" 
                                                @if(request()->get('course') == $row->id) selected @endif>
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md">
                                <select name="status" class="form-select select2" id="status-select">
                                    <option value="" selected>All Status</option>
                                    <option value="1" @if(request()->get('status') == '1') selected @endif>Active</option>
                                    <option value="0" @if(request()->get('status') == '0') selected @endif>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <input type="text" name="search" class="form-control" value="{{request()->get('search')}}" placeholder="Search name, email, phone">
                            </div>
                            <!-- <div class="col-md">
                                <input type="date" name="validity_from" class="form-control" value="{{request()->get('validity_from')}}" placeholder="Validity From">
                            </div>
                            <div class="col-md">
                                <input type="date" name="validity_to" class="form-control" value="{{request()->get('validity_to')}}" placeholder="Validity To">
                            </div> -->
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
                            <div class="col-md-2">
                                <div class="text-end">
                                    <button onclick="smallModal('{{url(route('course-enrolments.create'))}}', 'Add New')"
                                    class="btn btn-primary w-100 btn-icon"><i class="ti ti-plus"></i> Add New</button>
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input check-all" id="select-all">
                            <label class="form-check-label" for="select-all">Select All</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <form id="bulk-action-form">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input check-all-header" id="select-all-header">
                                </th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Validity</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pageData as $index => $row)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input check-one" name="id[]" value="{{ $row->id }}">
                                </td>
                                <td>{{ $pageData->firstItem() + $index }}</td>
                                <td>{{ $row->user->name ?? 'N/A' }}</td>
                                <td>
                                    @if(!empty($row->user->email))
                                        <a href="{{ route('students.index', ['search' => $row->user->email]) }}"
                                        target="_blank"
                                        class="text-primary">
                                            {{ text_limit($row->user->email) }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $row->user->phone ?? 'N/A' }}</td>
                                <td>
                                    @if($row->course)
                                        <a href="{{ url('backend/courses?search=' . urlencode($row->course->name)) }}" 
                                        target="_blank" 
                                        class="text-primary">
                                            {{ text_limit($row->course->name) }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $row->validity ? formatDate($row->validity) : 'N/A' }}</td>
                                <td>
                                <span class="badge {{ $row->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $row->is_active ? 'Active' : 'Inactive' }}
                                </span>                                    
                                </td>
                                <td>{{ formatDatetime($row->created_at) }}</td>
                                <td>{{ formatDatetime($row->updated_at) }}</td>                                
                                <td>
                                    <a href="javascript:void(0);" onclick="smallModal('{{url(route('course-enrolments.edit', $row->id))}}', 'Edit')" class="link-reset fs-20 p-1"> <i class="ti ti-pencil"></i></a>
                                    <a href="javascript:void(0);" onclick="confirmModal('{{ route('course-enrolments.destroy', $row->id) }}', callbackCourseEnrolments )" class="link-reset fs-20 p-1"> <i class="ti ti-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </form>
                    {{ $pageData->appends(request()->input())->links() }}
                </div> <!-- end table-responsive-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div><!-- end row-->

<script defer>
const callbackCourseEnrolments = function(response) {
    setTimeout(function() {
        location.reload();
    }, 1500);
}

// Select All functionality
$(document).on("change", ".check-all, .check-all-header", function() {
    if(this.checked) {
        $('.check-one:checkbox').each(function() {
            this.checked = true;
        });
        $('#select-all').prop('checked', true);
        $('#select-all-header').prop('checked', true);
    } else {
        $('.check-one:checkbox').each(function() {
            this.checked = false;
        });
        $('#select-all').prop('checked', false);
        $('#select-all-header').prop('checked', false);
    }
    updateBulkActionButton();
});

// Update bulk action button state
$(document).on("change", ".check-one", function() {
    updateBulkActionButton();
});

function updateBulkActionButton() {
    const checkedCount = $('.check-one:checked').length;
    const $bulkBtn = $('#bulk-action-btn');
    
    if (checkedCount > 0) {
        $bulkBtn.prop('disabled', false);
        $bulkBtn.text('Bulk Action (' + checkedCount + ')');
    } else {
        $bulkBtn.prop('disabled', true);
        $bulkBtn.text('Bulk Action');
    }
}

// Show Bulk Delete Modal
function showBulkDeleteModal() {
    const checkedCount = $('.check-one:checked').length;
    if (checkedCount === 0) {
        alert('Please select at least one enrolment.');
        return;
    }
    $('#bulk-delete-modal').modal('show');
}

// Show Bulk Active Modal
function showBulkActiveModal() {
    const checkedCount = $('.check-one:checked').length;
    if (checkedCount === 0) {
        alert('Please select at least one enrolment.');
        return;
    }
    $('#bulk-active-modal').modal('show');
}

// Show Bulk Inactive Modal
function showBulkInactiveModal() {
    const checkedCount = $('.check-one:checked').length;
    if (checkedCount === 0) {
        alert('Please select at least one enrolment.');
        return;
    }
    $('#bulk-inactive-modal').modal('show');
}

// Execute Bulk Delete - called from centralized modal
function executeBulkDelete() {
    const selectedIds = [];
    $('.check-one:checked').each(function() {
        selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
        $('#bulk-delete-modal').modal('hide');
        alert('Please select at least one enrolment.');
        return;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('course-enrolments.bulk-delete') }}",
        type: 'POST',
        data: {
            id: selectedIds
        },
        success: function (response) {
            $('#bulk-delete-modal').modal('hide');
            if(response.status) {
                // Show success notification
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.notification || 'Enrolments deleted successfully!', 'Success');
                } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                    AIZ.plugins.notify('success', response.notification || 'Enrolments deleted successfully!');
                } else {
                    alert(response.notification || 'Enrolments deleted successfully!');
                }
                // Reload page after showing notification
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                // Show error notification
                if (typeof toastr !== 'undefined') {
                    toastr.error(response.notification || 'Something went wrong.', 'Error');
                } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                    AIZ.plugins.notify('danger', response.notification || 'Something went wrong.');
                } else {
                    alert(response.notification || 'Something went wrong.');
                }
            }
        },
        error: function() {
            $('#bulk-delete-modal').modal('hide');
            if (typeof toastr !== 'undefined') {
                toastr.error('Something went wrong. Please try again.', 'Error');
            } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify('danger', 'Something went wrong.');
            } else {
                alert('Something went wrong.');
            }
        }
    });
}

// Execute Bulk Active - called from centralized modal
function executeBulkActive() {
    const selectedIds = [];
    $('.check-one:checked').each(function() {
        selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
        $('#bulk-active-modal').modal('hide');
        alert('Please select at least one enrolment.');
        return;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('course-enrolments.bulk-active') }}",
        type: 'POST',
        data: {
            id: selectedIds
        },
        success: function (response) {
            $('#bulk-active-modal').modal('hide');
            if(response.status) {
                // Show success notification
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.notification || 'Enrolments activated successfully!', 'Success');
                } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                    AIZ.plugins.notify('success', response.notification || 'Enrolments activated successfully!');
                } else {
                    alert(response.notification || 'Enrolments activated successfully!');
                }
                // Reload page after showing notification
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                // Show error notification
                if (typeof toastr !== 'undefined') {
                    toastr.error(response.notification || 'Something went wrong.', 'Error');
                } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                    AIZ.plugins.notify('danger', response.notification || 'Something went wrong.');
                } else {
                    alert(response.notification || 'Something went wrong.');
                }
            }
        },
        error: function() {
            $('#bulk-active-modal').modal('hide');
            if (typeof toastr !== 'undefined') {
                toastr.error('Something went wrong. Please try again.', 'Error');
            } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify('danger', 'Something went wrong.');
            } else {
                alert('Something went wrong.');
            }
        }
    });
}

// Execute Bulk Inactive - called from centralized modal
function executeBulkInactive() {
    const selectedIds = [];
    $('.check-one:checked').each(function() {
        selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
        $('#bulk-inactive-modal').modal('hide');
        alert('Please select at least one enrolment.');
        return;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('course-enrolments.bulk-inactive') }}",
        type: 'POST',
        data: {
            id: selectedIds
        },
        success: function (response) {
            $('#bulk-inactive-modal').modal('hide');
            if(response.status) {
                // Show success notification
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.notification || 'Enrolments deactivated successfully!', 'Success');
                } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                    AIZ.plugins.notify('success', response.notification || 'Enrolments deactivated successfully!');
                } else {
                    alert(response.notification || 'Enrolments deactivated successfully!');
                }
                // Reload page after showing notification
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                // Show error notification
                if (typeof toastr !== 'undefined') {
                    toastr.error(response.notification || 'Something went wrong.', 'Error');
                } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                    AIZ.plugins.notify('danger', response.notification || 'Something went wrong.');
                } else {
                    alert(response.notification || 'Something went wrong.');
                }
            }
        },
        error: function() {
            $('#bulk-inactive-modal').modal('hide');
            if (typeof toastr !== 'undefined') {
                toastr.error('Something went wrong. Please try again.', 'Error');
            } else if (typeof AIZ !== 'undefined' && AIZ.plugins && AIZ.plugins.notify) {
                AIZ.plugins.notify('danger', 'Something went wrong.');
            } else {
                alert('Something went wrong.');
            }
        }
    });
}

// When the category changes, fetch courses for that category via AJAX
$(document).ready(function () {
    $('#category-select').on('change', function () {
        const categoryId = $(this).val();
        const $courseSelect = $('#course-select');

        if (!categoryId) {
            $courseSelect.html('<option value="">All Courses</option>').trigger('change.select2');
            return false;
        }

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
                let options = '<option value="">All Courses</option>';

                if (Array.isArray(response) && response.length) {
                    response.forEach(function (course) {
                        const selected = '{{ request()->get('course') }}' == course.id ? ' selected' : '';
                        options += '<option value="' + course.id + '"' + selected + '>' + course.name + '</option>';
                    });
                }

                $courseSelect.html(options).trigger('change.select2');
            },
            error: function () {
                // On error, just reset to default option
                $courseSelect.html('<option value="">All Courses</option>').trigger('change.select2');
            }
        });
    });

    // Trigger change on page load if category is already selected
    @if(request()->get('category'))
        $('#category-select').trigger('change');
    @endif
});
</script>
@endsection

