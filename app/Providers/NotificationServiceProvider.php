<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Reservasi;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Berbagi data ke view be.navbar dan be.sidebar
        View::composer(['be.navbar', 'be.sidebar'], function ($view) {
            if (auth()->check() && auth()->user()->level == 'bendahara') {
                $count = Reservasi::where('status_reservasi', 'Dipesan')->count();
                $latest = Reservasi::where('status_reservasi', 'Dipesan')
                                    ->latest()
                                    ->take(5)
                                    ->get();
                
                $view->with([
                    'notifCount' => $count,
                    'notifItems' => $latest
                ]);
            }
        });
    }
}