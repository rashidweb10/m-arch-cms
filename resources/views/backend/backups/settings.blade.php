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
        <a href="{{ route('backup-schedules.index') }}" class="btn btn-secondary btn-sm">
            <i class="ti ti-calendar"></i> Schedules
        </a>
    </div>
</div>
@include('backend.includes.alert-message')

<form class="form" action="{{ route($routeName . '.update') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <!-- General Settings -->
            <div class="card">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-2">General Settings</h5>
                    
                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="backup_enabled" value="1" id="backup_enabled" {{ $settings['backup_enabled'] ?? true ? 'checked' : '' }}>
                            <label class="form-check-label" for="backup_enabled">
                                Enable Backup System
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="backup_name_prefix" class="form-label">Backup Name Prefix</label>
                        <input type="text" id="backup_name_prefix" name="backup_name_prefix" value="{{ $settings['backup_name_prefix'] ?? 'backup' }}" class="form-control" required>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="max_backups_to_keep" class="form-label">Max Backups to Keep</label>
                        <input type="number" id="max_backups_to_keep" name="max_backups_to_keep" value="{{ $settings['max_backups_to_keep'] ?? 10 }}" class="form-control" min="1" max="1000" required>
                    </div>

                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="auto_delete_old_backups" value="1" id="auto_delete_old_backups" {{ $settings['auto_delete_old_backups'] ?? true ? 'checked' : '' }}>
                            <label class="form-check-label" for="auto_delete_old_backups">
                                Auto-delete Old Backups
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="compression_type" class="form-label">Compression Type</label>
                        <select name="compression_type" id="compression_type" class="form-select" required>
                            <option value="zip" {{ ($settings['compression_type'] ?? 'zip') == 'zip' ? 'selected' : '' }}>ZIP</option>
                            <option value="tar.gz" {{ ($settings['compression_type'] ?? 'zip') == 'tar.gz' ? 'selected' : '' }}>TAR.GZ</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Storage Settings -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-2">Storage Settings</h5>
                    
                    <div class="mb-3 form-group">
                        <label for="storage_disk" class="form-label">Storage Disk</label>
                        <select name="storage_disk" id="storage_disk" class="form-select" required>
                            <option value="local" {{ ($settings['storage_disk'] ?? 'local') == 'local' ? 'selected' : '' }}>Local</option>
                            <option value="public" {{ ($settings['storage_disk'] ?? 'local') == 'public' ? 'selected' : '' }}>Public</option>
                        </select>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="storage_path" class="form-label">Storage Path</label>
                        <input type="text" id="storage_path" name="storage_path" value="{{ $settings['storage_path'] ?? 'backups' }}" class="form-control" required>
                    </div>

                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="check_disk_space" value="1" id="check_disk_space" {{ $settings['check_disk_space'] ?? true ? 'checked' : '' }}>
                            <label class="form-check-label" for="check_disk_space">
                                Check Disk Space Before Backup
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="min_disk_space_mb" class="form-label">Minimum Disk Space (MB)</label>
                        <input type="number" id="min_disk_space_mb" name="min_disk_space_mb" value="{{ $settings['min_disk_space_mb'] ?? 100 }}" class="form-control" min="1" required>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-2">Security Settings</h5>
                    
                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="encrypt_backups" value="1" id="encrypt_backups" {{ $settings['encrypt_backups'] ?? false ? 'checked' : '' }}>
                            <label class="form-check-label" for="encrypt_backups">
                                Encrypt Backups
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="exclude_env_file" value="1" id="exclude_env_file" {{ $settings['exclude_env_file'] ?? true ? 'checked' : '' }}>
                            <label class="form-check-label" for="exclude_env_file">
                                Exclude .env File
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="exclude_sensitive_files" value="1" id="exclude_sensitive_files" {{ $settings['exclude_sensitive_files'] ?? true ? 'checked' : '' }}>
                            <label class="form-check-label" for="exclude_sensitive_files">
                                Exclude Sensitive Files
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Settings -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-2">Performance Settings</h5>
                    
                    <div class="mb-3 form-group">
                        <label for="memory_limit" class="form-label">Memory Limit</label>
                        <input type="text" id="memory_limit" name="memory_limit" value="{{ $settings['memory_limit'] ?? '512M' }}" class="form-control" required>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="timeout" class="form-label">Timeout (seconds)</label>
                        <input type="number" id="timeout" name="timeout" value="{{ $settings['timeout'] ?? 3600 }}" class="form-control" min="60" required>
                    </div>

                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="use_queue" value="1" id="use_queue" {{ $settings['use_queue'] ?? true ? 'checked' : '' }}>
                            <label class="form-check-label" for="use_queue">
                                Run Backups Via Queue
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-2">Notification Settings</h5>
                    
                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_on_failure" value="1" id="email_on_failure" {{ $settings['email_on_failure'] ?? true ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_on_failure">
                                Email Notification on Failure
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_on_success" value="1" id="email_on_success" {{ $settings['email_on_success'] ?? false ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_on_success">
                                Email Notification on Success
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="notification_email" class="form-label">Notification Email</label>
                        <input type="email" id="notification_email" name="notification_email" value="{{ $settings['notification_email'] ?? '' }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-uppercase mt-0 mb-2 bg-light p-2">Actions</h5>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-save"></i> Save Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script defer>
initValidate('.form');
</script>
@endsection

