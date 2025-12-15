@extends('backend.layouts.app')

@section('content')
<div class="page-title-head d-flex align-items-center gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-16 text-uppercase fw-bold mb-0">{{$moduleName}}</h4>
    </div>
    <div class="text-end">
        <a href="{{ route('backup-schedules.index') }}" class="btn btn-info btn-sm me-2">
            <i class="ti ti-calendar"></i> Schedules
        </a>
        <a href="{{ route('backup-settings.index') }}" class="btn btn-secondary btn-sm me-2">
            <i class="ti ti-settings"></i> Settings
        </a>
        <a href="{{ route($routeName . '.create') }}" class="btn btn-primary btn-sm">
            <i class="ti ti-plus"></i> Create Backup
        </a>
    </div>
</div>
@include('backend.includes.alert-message')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header border-bottom border-dashed align-items-center">
                <div class="row">
                    <div class="col-md-8">
                        <form class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" value="{{request()->get('search')}}" placeholder="Search">
                            </div>
                            <div class="col-md-2">
                                <select name="type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="database" {{request()->get('type') == 'database' ? 'selected' : ''}}>Database</option>
                                    <option value="codebase" {{request()->get('type') == 'codebase' ? 'selected' : ''}}>Codebase</option>
                                    <option value="combined" {{request()->get('type') == 'combined' ? 'selected' : ''}}>Combined</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="success" {{request()->get('status') == 'success' ? 'selected' : ''}}>Success</option>
                                    <option value="failed" {{request()->get('status') == 'failed' ? 'selected' : ''}}>Failed</option>
                                    <option value="running" {{request()->get('status') == 'running' ? 'selected' : ''}}>Running</option>
                                    <option value="pending" {{request()->get('status') == 'pending' ? 'selected' : ''}}>Pending</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success btn-icon w-100">
                                    <i class="ti ti-search"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="reset" class="btn btn-warning btn-icon w-100" 
                                    onclick="window.location.href = '{{ route(Route::currentRouteName()) }}';">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>File Size</th>
                                <th>Duration</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($backups as $index => $backup)
                            <tr>
                                <td>{{ $backups->firstItem() + $index }}</td>
                                <td>{{ $backup->name }}</td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($backup->type) }}</span>
                                </td>
                                <td>
                                    @if($backup->status == 'success')
                                        <span class="badge bg-success">Success</span>
                                    @elseif($backup->status == 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @elseif($backup->status == 'running')
                                        <span class="badge bg-warning">Running</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($backup->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $backup->formatted_file_size }}</td>
                                <td>{{ $backup->formatted_duration }}</td>
                                <td>{{ $backup->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @if($backup->status == 'success' && $backup->file_path)
                                        <a href="{{ route($routeName . '.download', $backup->id) }}" class="link-reset fs-20 p-1" title="Download">
                                            <i class="ti ti-download"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route($routeName . '.logs', $backup->id) }}" class="link-reset fs-20 p-1" title="View Logs">
                                        <i class="ti ti-file-text"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmModal('{{ route($routeName . '.destroy', $backup->id) }}', callback)" class="link-reset fs-20 p-1" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No backups found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $backups->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script defer>
const callback = function(response) {
    setTimeout(function() {
        location.reload();
    }, 1500);
}
</script>
@endsection

