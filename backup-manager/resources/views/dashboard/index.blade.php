@extends('backup-manager::layouts.app')

@section('title', 'Dashboard')
@section('header', 'Backup Dashboard')
@section('subheader', 'Overview of recent backups and configuration')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-xs font-semibold text-gray-500 mb-1">Last Backup</h3>
            <p class="text-lg font-semibold">{{ $summary['last_backup_at'] ?? 'Never' }}</p>
            <p class="text-xs text-gray-500 mt-1">Status: {{ $summary['last_backup_status'] ?? 'N/A' }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-xs font-semibold text-gray-500 mb-1">Total Backups</h3>
            <p class="text-lg font-semibold">{{ $summary['total_backups'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-xs font-semibold text-gray-500 mb-1">Used Space (approx)</h3>
            <p class="text-lg font-semibold">{{ $summary['used_space'] ?? '0 MB' }}</p>
        </div>
    </div>

    <div class="bg-white rounded shadow">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-700">Recent Backups</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Type</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Destinations</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Size</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($recentBackups as $backup)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $backup->created_at }}</td>
                        <td class="px-4 py-2 whitespace-nowrap capitalize">{{ $backup->type }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ implode(', ', $backup->destinations ?? []) }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $backup->size_human }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs
                                @if($backup->status === 'success') bg-green-100 text-green-800
                                @elseif($backup->status === 'running') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($backup->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-xs text-gray-500">
                            No backups have been created yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection


