@extends('backup-manager::layouts.app')

@section('title', 'Logs')
@section('header', 'Backup Logs')
@section('subheader', 'Recent log entries from backup manager')

@section('content')
    <div class="bg-white rounded shadow">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center text-sm">
            <h3 class="font-semibold text-gray-700">Log Output</h3>
        </div>
        <div class="p-4 text-xs font-mono bg-gray-900 text-gray-100 rounded-b max-h-[600px] overflow-y-auto whitespace-pre-wrap">
            {{ $logContent ?: 'No log entries found.' }}
        </div>
    </div>
@endsection


