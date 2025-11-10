<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-run migrations on Vercel if database is empty
        if (getenv('VERCEL') || getenv('DB_DATABASE') === '/tmp/database.sqlite') {
            try {
                // Check if migrations table exists
                if (!Schema::hasTable('migrations')) {
                    Artisan::call('migrate', ['--force' => true]);
                }
            } catch (\Exception $e) {
                // Log error but don't crash - database might not be ready yet
                if (config('app.debug')) {
                    error_log('Migration error: ' . $e->getMessage());
                }
            }
        }
    }
}
