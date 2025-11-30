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
                            <div class="col-md-3">
                                <select name="course" class="form-select select2" id="course-select">
                                    <option value="" selected>All Courses</option>
                                    @foreach ($courseList as $index => $row)
                                        <option value="{{ $row->id }}" 
                                            @if(request()->get('course') == $row->id) selected @endif>
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select select2" id="status-select">
                                    <option value="" selected>All Status</option>
                                    <option value="1" @if(request()->get('status') == '1') selected @endif>Active</option>
                                    <option value="0" @if(request()->get('status') == '0') selected @endif>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" value="{{request()->get('search')}}" placeholder="Search with title">
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
                        <button onclick="smallModal('{{url(route('course-materials.create'))}}', 'Add New')"
                        class="btn btn-primary btn-icon w-100"><i class="ti ti-plus"></i> Add New</button>        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Attachments</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pageData as $index => $row)
                            <tr>
                                <td>{{ $pageData->firstItem() + $index }}</td>
                                <td>{{ $row->course->name ?? 'N/A' }}</td>
                                <td>{{ $row->title ?? 'N/A' }}</td>
                                <td>{{ Str::limit($row->description ?? 'N/A', 50) }}</td>
                                <td>
                                    @if($row->attachments)
                                        @php
                                            $attachments = is_string($row->attachments) ? json_decode($row->attachments, true) : $row->attachments;
                                            $attachmentCount = is_array($attachments) ? count($attachments) : 0;
                                        @endphp
                                        @if($attachmentCount > 0)
                                            <span class="badge bg-info">{{ $attachmentCount }} file(s)</span>
                                        @else
                                            No files
                                        @endif
                                    @else
                                        No files
                                    @endif
                                </td>
                                <td>
                                <span class="badge {{ $row->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $row->is_active ? 'Active' : 'Inactive' }}
                                </span>                                    
                                </td>
                                <td>{{ formatDatetime($row->created_at) }}</td>
                                <td>{{ formatDatetime($row->updated_at) }}</td>                                
                                <td>
                                    <a href="javascript:void(0);" onclick="smallModal('{{url(route('course-materials.edit', $row->id))}}', 'Edit')" class="link-reset fs-20 p-1"> <i class="ti ti-pencil"></i></a>
                                    <a href="javascript:void(0);" onclick="confirmModal('{{ route('course-materials.destroy', $row->id) }}', callbackCourseMaterials )" class="link-reset fs-20 p-1"> <i class="ti ti-trash"></i></a>
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
const callbackCourseMaterials = function(response) {
    setTimeout(function() {
        location.reload();
    }, 1500);
}
</script>
@endsection

