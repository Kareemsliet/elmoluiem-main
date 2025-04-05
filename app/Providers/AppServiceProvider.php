<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        ini_set('memory_limit', '512M',);
        ini_set('max_execution_time', 300);
        ini_set('upload_max_filesize', '512M');
        ini_set('post_max_size', '512M');
        ini_set('max_file_uploads', '20');
    }
}
