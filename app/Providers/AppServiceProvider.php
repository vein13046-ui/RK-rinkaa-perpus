<?php

namespace App\Providers;

use App\Models\BorrowRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.panel', function ($view) {
            BorrowRequest::expireOverduePickups();

            $user = Auth::user();

            if (! $user) {
                return;
            }

            if (($user->role ?? 'user') === 'admin') {
                $borrowNotifications = BorrowRequest::with(['user', 'book'])
                    ->whereIn('status', ['pending', 'return_pending'])
                    ->latest()
                    ->take(5)
                    ->get();

                $borrowNotificationCount = BorrowRequest::whereIn('status', ['pending', 'return_pending'])->count();
            } else {
                $borrowNotifications = BorrowRequest::with('book')
                    ->where('user_id', $user->id)
                    ->whereIn('status', ['pending', 'approved', 'picked_up', 'return_pending', 'rejected', 'cancelled', 'returned'])
                    ->latest()
                    ->take(5)
                    ->get();

                $borrowNotificationCount = BorrowRequest::where('user_id', $user->id)
                    ->whereIn('status', ['pending', 'approved', 'picked_up', 'return_pending'])
                    ->count();
            }

            $view->with([
                'borrowNotifications' => $borrowNotifications,
                'borrowNotificationCount' => $borrowNotificationCount,
            ]);
        });
    }
}
