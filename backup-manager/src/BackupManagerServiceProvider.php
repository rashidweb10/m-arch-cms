<?php

namespace Marinarch\BackupManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Marinarch\BackupManager\Console\RunBackupCommand;

class BackupManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerMigrations();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerPublishing();
        $this->registerCommands();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/backup-manager.php', 'backup-manager');
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/backup-manager.php' => config_path('backup-manager.php'),
        ], 'backup-manager-config');
    }

    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function registerRoutes(): void
    {
        Route::group([
            'prefix' => config('backup-manager.route_prefix', 'admin/backup-manager'),
            'middleware' => config('backup-manager.middleware', ['web', 'auth']),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });

        if ($this->app->runningInConsole()) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/console.php');
        }
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'backup-manager');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/backup-manager'),
        ], 'backup-manager-views');
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../config/backup-manager.php' => config_path('backup-manager.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/backup-manager'),
            __DIR__ . '/../public' => public_path('vendor/backup-manager'),
        ], 'backup-manager-assets');
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RunBackupCommand::class,
            ]);
        }
    }
}


