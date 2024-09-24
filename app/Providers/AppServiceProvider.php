<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Peminjaman;
use Illuminate\Pagination\Paginator;
use App\Observers\PeminjamanObserver;
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
        Paginator::useBootstrapFour();
        Carbon::setLocale('id');
        Peminjaman::observe(PeminjamanObserver::class);
    }
}
