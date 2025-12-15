@extends('backend.layouts.app')

@section('content')
<div class="page-title-head d-flex align-items-center gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-16 text-uppercase fw-bold mb-0">Backup Logs - {{ $backup->name }}</h4>
    </div>
    <div class="text-end">
        <a href="{{ route('backups.index') }}" class="btn btn-secondary btn-sm">
            <i class="ti ti-arrow-left"></i> Back to Backups
        </a>
    </div>
</div>
@include('backend.includes.alert-message')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Backup Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Name:</strong> {{ $backup->name }}
                    </div>
                    <div class="col-md-3">
                        <strong>Type:</strong> <span class="badge bg-info">{{ ucfirst($backup->type) }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Status:</strong> 
                        @if($backup->status == 'success')
                            <span class="badge bg-success">Success</span>
                        @elseif($backup->status == 'failed')
                            <span class="badge bg-danger">Failed</span>
                        @else
                            <span class="badge bg-warning">{{ ucfirst($backup->status) }}</span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong>File Size:</strong> {{ $backup->formatted_file_size }}
                    </div>
                </div>
                @if($backup->error_message)
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <strong>Error:</strong> {{ $backup->error_message }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Logs</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Level</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($backup->logs as $log)
                            <tr>
                                <td>{{ $log->logged_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @if($log->level == 'error')
                                        <span class="badge bg-danger">Error</span>
                                    @elseif($log->level == 'warning')
                                        <span class="badge bg-warning">Warning</span>
                                    @elseif($log->level == 'success')
                                        <span class="badge bg-success">Success</span>
                                    @else
                                        <span class="badge bg-info">Info</span>
                                    @endif
                                </td>
                                <td>{{ $log->message }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No logs found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

