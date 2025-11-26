<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup Manager - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
<div class="min-h-screen flex">
    <aside class="w-64 bg-gray-900 text-gray-100">
        <div class="px-6 py-4 border-b border-gray-800">
            <h1 class="text-lg font-semibold">Backup Manager</h1>
            <p class="text-xs text-gray-400">Laravel Backup Panel</p>
        </div>
        <nav class="px-4 py-4 space-y-1 text-sm">
            <a href="{{ route('backup-manager.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('backup-manager.dashboard') ? 'bg-gray-800' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('backup-manager.settings.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('backup-manager.settings.*') ? 'bg-gray-800' : '' }}">
                Settings
            </a>
            <a href="{{ route('backup-manager.history.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('backup-manager.history.*') ? 'bg-gray-800' : '' }}">
                History
            </a>
            <a href="{{ route('backup-manager.logs.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('backup-manager.logs.*') ? 'bg-gray-800' : '' }}">
                Logs
            </a>
        </nav>
    </aside>
    <main class="flex-1">
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold">@yield('header', 'Backup Manager')</h2>
                    <p class="text-xs text-gray-500">@yield('subheader')</p>
                </div>
                <form method="POST" action="{{ route('backup-manager.run.store') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded shadow hover:bg-indigo-700 focus:outline-none">
                        Run Backup Now
                    </button>
                </form>
            </div>
        </header>
        <section class="max-w-6xl mx-auto px-6 py-6">
            @if (session('backup_manager_success'))
                <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-3 text-sm">
                    {{ session('backup_manager_success') }}
                </div>
            @endif
            @if (session('backup_manager_error'))
                <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-3 text-sm">
                    {{ session('backup_manager_error') }}
                </div>
            @endif

            @yield('content')
        </section>
    </main>
</div>
</body>
</html>


