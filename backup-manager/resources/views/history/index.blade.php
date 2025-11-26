@extends('backup-manager::layouts.app')

@section('title', 'History')
@section('header', 'Backup History')
@section('subheader', 'List of all backup jobs executed')

@section('content')
    <div class="bg-white rounded shadow">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center text-sm">
            <h3 class="font-semibold text-gray-700">Backup Jobs</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Type</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Destinations</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Size</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Message</th>
                </tr>
                </thead>
                <tbody>
                @forelse($backups as $backup)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">{{ $backup->id }}</td>
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
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500 max-w-xs truncate"
                            title="{{ $backup->message }}">{{ $backup->message }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-xs text-gray-500">
                            No backups have been created yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection


