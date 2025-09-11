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
        \View::composer('*', function ($view) {
            $overdueBooksCount = \App\Models\pinjamBuku::where('tanggal_kembali', '<', \Carbon\Carbon::now())
                ->where('status', 'dipinjam')
                ->count();

            if ($overdueBooksCount > 0) {
                $view->with('overdueBooksCount', $overdueBooksCount);
            }
        });
    }
}
