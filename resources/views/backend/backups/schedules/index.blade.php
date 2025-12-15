@extends('backend.layouts.app')

@section('content')
<div class="page-title-head d-flex align-items-center gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-16 text-uppercase fw-bold mb-0">{{$moduleName}}</h4>
    </div>
    <div class="text-end">
        <a href="{{ route('backups.index') }}" class="btn btn-info btn-sm me-2">
            <i class="ti ti-list"></i> Backups
        </a>
        <a href="{{ route('backup-settings.index') }}" class="btn btn-secondary btn-sm me-2">
            <i class="ti ti-settings"></i> Settings
        </a>
        <a href="{{ route($routeName . '.create') }}" class="btn btn-primary btn-sm">
            <i class="ti ti-plus"></i> Create Schedule
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
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{request()->get('search')}}" placeholder="Search">
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
                                <th>Frequency</th>
                                <th>Status</th>
                                <th>Last Run</th>
                                <th>Next Run</th>
                                <th>Backups</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $index => $schedule)
                            <tr>
                                <td>{{ $schedules->firstItem() + $index }}</td>
                                <td>{{ $schedule->name }}</td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($schedule->type) }}</span>
                                </td>
                                <td>{{ ucfirst($schedule->frequency) }}</td>
                                <td>
                                    @if($schedule->is_enabled)
                                        <span class="badge bg-success">Enabled</span>
                                    @else
                                        <span class="badge bg-secondary">Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($schedule->last_run_at)
                                        {{ $schedule->last_run_at->format('Y-m-d H:i:s') }}
                                        @if($schedule->last_status == 'success')
                                            <span class="badge bg-success ms-1">Success</span>
                                        @elseif($schedule->last_status == 'failed')
                                            <span class="badge bg-danger ms-1">Failed</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td>
                                    @if($schedule->next_run_at)
                                        {{ $schedule->next_run_at->format('Y-m-d H:i:s') }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $schedule->backups_count }}</td>
                                <td>
                                    <a href="{{ route($routeName . '.edit', $schedule->id) }}" class="link-reset fs-20 p-1" title="Edit">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="runSchedule({{ $schedule->id }})" class="link-reset fs-20 p-1" title="Run Now">
                                        <i class="ti ti-play"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="toggleSchedule({{ $schedule->id }})" class="link-reset fs-20 p-1" title="Toggle">
                                        <i class="ti ti-toggle-{{ $schedule->is_enabled ? 'left' : 'right' }}"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmModal('{{ route($routeName . '.destroy', $schedule->id) }}', callback)" class="link-reset fs-20 p-1" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No schedules found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $schedules->appends(request()->input())->links() }}
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

function runSchedule(id) {
    if (confirm('Are you sure you want to run this schedule now?')) {
        fetch(`/backend/backup-schedules/${id}/run`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json().catch(() => ({ success: true }));
            }
            return response.json().then(data => Promise.reject(data));
        })
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to run schedule'));
            }
        })
        .catch(error => {
            alert('Error: ' + (error.message || 'Failed to run schedule'));
        });
    }
}

function toggleSchedule(id) {
    fetch(`/backend/backup-schedules/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json().catch(() => ({ success: true }));
        }
        return response.json().then(data => Promise.reject(data));
    })
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to toggle schedule'));
        }
    })
    .catch(error => {
        alert('Error: ' + (error.message || 'Failed to toggle schedule'));
    });
}
</script>
@endsection

