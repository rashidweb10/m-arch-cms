@extends('backup-manager::layouts.app')

@section('title', 'Settings')
@section('header', 'Backup Settings')
@section('subheader', 'Configure backup frequencies, destinations, and limits')

@section('content')
    <form method="POST" action="{{ route('backup-manager.settings.store') }}" class="space-y-6">
        @csrf

        <div class="bg-white rounded shadow p-4 space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Frequencies</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @foreach($settings['schedules'] as $key => $schedule)
                    <div class="border rounded p-3">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="schedules[{{ $key }}][enabled]" value="1"
                                   @checked($schedule['enabled']) class="rounded border-gray-300">
                            <span class="font-semibold capitalize">{{ $key }}</span>
                        </label>
                        <div class="mt-2">
                            <label class="block text-xs text-gray-500 mb-1">CRON Expression</label>
                            <input type="text"
                                   name="schedules[{{ $key }}][cron]"
                                   value="{{ $schedule['cron'] }}"
                                   class="w-full border-gray-300 rounded text-xs px-2 py-1">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded shadow p-4 space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Destinations</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                @foreach($settings['destinations'] as $key => $destination)
                    <div class="border rounded p-3 space-y-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="destinations[{{ $key }}][enabled]" value="1"
                                   @checked($destination['enabled']) class="rounded border-gray-300">
                            <span class="font-semibold uppercase">{{ $key }}</span>
                        </label>

                        @if($key === 'local')
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Root Path</label>
                                <input type="text"
                                       name="destinations[local][root_path]"
                                       value="{{ $destination['root_path'] }}"
                                       class="w-full border-gray-300 rounded text-xs px-2 py-1">
                            </div>
                        @else
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Disk Name</label>
                                <input type="text"
                                       name="destinations[{{ $key }}][disk]"
                                       value="{{ $destination['disk'] ?? '' }}"
                                       class="w-full border-gray-300 rounded text-xs px-2 py-1">
                            </div>
                            <div class="mt-2">
                                <label class="block text-xs text-gray-500 mb-1">Base Path</label>
                                <input type="text"
                                       name="destinations[{{ $key }}][base_path]"
                                       value="{{ $destination['base_path'] ?? '' }}"
                                       class="w-full border-gray-300 rounded text-xs px-2 py-1">
                            </div>
                        @endif

                        <button type="button"
                                data-driver="{{ $key }}"
                                class="mt-2 inline-flex items-center px-2 py-1 bg-gray-800 text-white text-xs rounded test-storage-btn">
                            Test Connection
                        </button>

                        <p class="mt-1 text-xs text-gray-500 storage-test-result" data-driver="{{ $key }}"></p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded shadow p-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Rotation</h3>
                <label class="flex items-center space-x-2 mb-2">
                    <input type="checkbox" name="rotation[enabled]" value="1"
                           @checked($settings['rotation']['enabled']) class="rounded border-gray-300">
                    <span class="text-xs">Enable rotation</span>
                </label>
                <label class="block text-xs text-gray-500 mb-1">Keep last N backups</label>
                <input type="number"
                       name="rotation[keep_last]"
                       value="{{ $settings['rotation']['keep_last'] }}"
                       min="1"
                       class="w-full border-gray-300 rounded text-xs px-2 py-1">
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Free Space</h3>
                <label class="block text-xs text-gray-500 mb-1">Min. free space (MB)</label>
                <input type="number"
                       name="space[min_free_megabytes]"
                       value="{{ $settings['space']['min_free_megabytes'] }}"
                       min="0"
                       class="w-full border-gray-300 rounded text-xs px-2 py-1">
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Logging</h3>
                <label class="block text-xs text-gray-500 mb-1">Log channel</label>
                <input type="text"
                       name="logging[channel]"
                       value="{{ $settings['logging']['channel'] }}"
                       class="w-full border-gray-300 rounded text-xs px-2 py-1 mb-2">
                <label class="flex items-center space-x-2 mb-2">
                    <input type="checkbox" name="logging[separate_log_file]" value="1"
                           @checked($settings['logging']['separate_log_file']) class="rounded border-gray-300">
                    <span class="text-xs">Use separate log file</span>
                </label>
                <label class="block text-xs text-gray-500 mb-1">Log file path</label>
                <input type="text"
                       name="logging[log_path]"
                       value="{{ $settings['logging']['log_path'] }}"
                       class="w-full border-gray-300 rounded text-xs px-2 py-1">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded shadow hover:bg-indigo-700">
                Save Settings
            </button>
        </div>
    </form>

    <form id="storage-test-form" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.test-storage-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const driver = this.getAttribute('data-driver');
                    const resultEl = document.querySelector('.storage-test-result[data-driver=\"' + driver + '\"]');
                    resultEl.textContent = 'Testing...';

                    fetch('{{ url(config('backup-manager.route_prefix')) }}/storage/' + driver + '/test', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(response => response.json())
                        .then(data => {
                            resultEl.textContent = data.message || 'Success';
                            resultEl.classList.remove('text-red-600');
                            resultEl.classList.add('text-green-600');
                        })
                        .catch(() => {
                            resultEl.textContent = 'Connection failed';
                            resultEl.classList.remove('text-green-600');
                            resultEl.classList.add('text-red-600');
                        });
                });
            });
        });
    </script>
@endsection


