@extends('backend.layouts.app')

@section('content')
<div class="page-title-head d-flex align-items-center gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-16 text-uppercase fw-bold mb-0">{{$moduleName}} / Edit</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0 fs-13">
            <li class="breadcrumb-item"><a href="{{ route($routeName . '.index') }}">Back to {{$moduleName}} list</a></li>
        </ol>
    </div>    
</div>

<form class="form" action="{{ route($routeName . '.update', $schedule->id) }}" method="POST">
    @include('backend.includes.alert-message')
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-2">Schedule Details</h5>
                    
                    <div class="mb-3 form-group">
                        <label for="name" class="form-label">Schedule Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $schedule->name) }}" class="form-control" placeholder="Enter schedule name" required>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="type" class="form-label">Backup Type <span class="text-danger">*</span></label>
                        <select name="type" id="backup_type" class="form-select" required onchange="toggleBackupOptions()">
                            <option value="database" {{ old('type', $schedule->type) == 'database' ? 'selected' : '' }}>Database Backup</option>
                            <option value="codebase" {{ old('type', $schedule->type) == 'codebase' ? 'selected' : '' }}>Codebase Backup</option>
                            <option value="combined" {{ old('type', $schedule->type) == 'combined' ? 'selected' : '' }}>Combined Backup</option>
                        </select>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="frequency" class="form-label">Frequency <span class="text-danger">*</span></label>
                        <select name="frequency" id="frequency" class="form-select" required onchange="toggleCronExpression()">
                            <option value="minutely" {{ old('frequency', $schedule->frequency) == 'minutely' ? 'selected' : '' }}>Minutely</option>
                            <option value="hourly" {{ old('frequency', $schedule->frequency) == 'hourly' ? 'selected' : '' }}>Hourly</option>
                            <option value="daily" {{ old('frequency', $schedule->frequency) == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('frequency', $schedule->frequency) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('frequency', $schedule->frequency) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="custom" {{ old('frequency', $schedule->frequency) == 'custom' ? 'selected' : '' }}>Custom Cron</option>
                        </select>
                    </div>

                    <div class="mb-3 form-group" id="cron_expression_group" style="display: {{ old('frequency', $schedule->frequency) == 'custom' ? 'block' : 'none' }};">
                        <label for="cron_expression" class="form-label">Cron Expression <span class="text-danger">*</span></label>
                        <input type="text" id="cron_expression" name="cron_expression" value="{{ old('cron_expression', $schedule->cron_expression ?? '* * * * *') }}" class="form-control" placeholder="* * * * *">
                        <small class="text-muted">Format: minute hour day month weekday (e.g., 0 2 * * * for daily at 2 AM)</small>
                    </div>

                    <div class="mb-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_enabled" value="1" id="is_enabled" {{ old('is_enabled', $schedule->is_enabled) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_enabled">
                                Enable Schedule
                            </label>
                        </div>
                    </div>

                    <!-- Database Options -->
                    <div id="database_options" style="display: {{ old('type', $schedule->type) == 'database' || old('type', $schedule->type) == 'combined' ? 'block' : 'none' }};">
                        <h6 class="mt-3 mb-2">Database Options</h6>
                        
                        @php
                            $dbOptions = old('database_options', $schedule->database_options ?? []);
                            $structureOnly = $dbOptions['structure_only'] ?? false;
                            $dataOnly = $dbOptions['data_only'] ?? false;
                            $selectedTables = $dbOptions['tables'] ?? [];
                        @endphp
                        
                        <div class="mb-3">
                            <label class="form-label">Backup Mode</label>
                            <div>
                                <input type="radio" name="database_options[structure_only]" value="0" id="db_full" {{ !$structureOnly && !$dataOnly ? 'checked' : '' }}>
                                <label for="db_full" class="ms-2">Structure + Data</label>
                            </div>
                            <div>
                                <input type="radio" name="database_options[structure_only]" value="1" id="db_structure" {{ $structureOnly ? 'checked' : '' }}>
                                <label for="db_structure" class="ms-2">Structure Only</label>
                            </div>
                            <div>
                                <input type="radio" name="database_options[data_only]" value="1" id="db_data" {{ $dataOnly ? 'checked' : '' }}>
                                <label for="db_data" class="ms-2">Data Only</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tables</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="selectAllTables()">Select All</button>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="deselectAllTables()">Deselect All</button>
                            </div>
                            <div class="mt-2" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                                @foreach($tables as $table)
                                <div class="form-check">
                                    <input class="form-check-input table-checkbox" type="checkbox" name="database_options[tables][]" value="{{ $table }}" id="table_{{ $table }}" {{ in_array($table, $selectedTables) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="table_{{ $table }}">{{ $table }}</label>
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Leave empty to backup all tables</small>
                        </div>
                    </div>

                    <!-- Codebase Options -->
                    <div id="codebase_options" style="display: {{ old('type', $schedule->type) == 'codebase' || old('type', $schedule->type) == 'combined' ? 'block' : 'none' }};">
                        <h6 class="mt-3 mb-2">Codebase Options</h6>
                        
                        @php
                            $codeOptions = old('codebase_options', $schedule->codebase_options ?? []);
                            $selectedFolders = $codeOptions['folders'] ?? [];
                        @endphp
                        
                        <div class="mb-3">
                            <label class="form-label">Folders to Include</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="selectAllFolders()">Select All</button>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="deselectAllFolders()">Deselect All</button>
                            </div>
                            <div class="mt-2" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                                @foreach($folders as $folder)
                                <div class="form-check">
                                    <input class="form-check-input folder-checkbox" type="checkbox" name="codebase_options[folders][]" value="{{ $folder }}" id="folder_{{ $folder }}" {{ in_array($folder, $selectedFolders) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="folder_{{ $folder }}">{{ $folder }}</label>
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Leave empty to backup entire codebase</small>
                        </div>

                        <div class="mb-3">
                            <label for="compression" class="form-label">Compression Type</label>
                            <select name="codebase_options[compression]" id="compression" class="form-select">
                                <option value="zip" {{ ($codeOptions['compression'] ?? 'zip') == 'zip' ? 'selected' : '' }}>ZIP</option>
                                <option value="tar.gz" {{ ($codeOptions['compression'] ?? 'zip') == 'tar.gz' ? 'selected' : '' }}>TAR.GZ</option>
                            </select>
                        </div>
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
                            <i class="ti ti-save"></i> Update Schedule
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script defer>
function toggleBackupOptions() {
    const type = document.getElementById('backup_type').value;
    const dbOptions = document.getElementById('database_options');
    const codeOptions = document.getElementById('codebase_options');
    
    if (type === 'database') {
        dbOptions.style.display = 'block';
        codeOptions.style.display = 'none';
    } else if (type === 'codebase') {
        dbOptions.style.display = 'none';
        codeOptions.style.display = 'block';
    } else if (type === 'combined') {
        dbOptions.style.display = 'block';
        codeOptions.style.display = 'block';
    }
}

function toggleCronExpression() {
    const frequency = document.getElementById('frequency').value;
    const cronGroup = document.getElementById('cron_expression_group');
    cronGroup.style.display = frequency === 'custom' ? 'block' : 'none';
}

function selectAllTables() {
    document.querySelectorAll('.table-checkbox').forEach(cb => cb.checked = true);
}

function deselectAllTables() {
    document.querySelectorAll('.table-checkbox').forEach(cb => cb.checked = false);
}

function selectAllFolders() {
    document.querySelectorAll('.folder-checkbox').forEach(cb => cb.checked = true);
}

function deselectAllFolders() {
    document.querySelectorAll('.folder-checkbox').forEach(cb => cb.checked = false);
}

initValidate('.form');
</script>
@endsection

