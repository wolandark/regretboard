<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS URLs on Vercel
        if (getenv('VERCEL') || getenv('FORCE_HTTPS') === 'true' || config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Auto-run migrations on Vercel if needed
        if (getenv('VERCEL')) {
            try {
                // Check if migrations table exists
                if (!Schema::hasTable('migrations')) {
                    Artisan::call('migrate', ['--force' => true]);
                } else {
                    // Check if token columns exist (for the new migrations)
                    if (Schema::hasTable('regrets') && !Schema::hasColumn('regrets', 'token')) {
                        Artisan::call('migrate', ['--force' => true]);
                    }
                }
            } catch (\Exception $e) {
                // Log error but don't crash - database might not be ready yet
                error_log('Migration error: ' . $e->getMessage());
            }
        }
    }
}
