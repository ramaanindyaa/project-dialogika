<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Observers\TransactionObserver;
use App\Repositories\CourseRepository;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\PricingRepository;
use App\Repositories\PricingRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\LearningProgressService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(PricingRepositoryInterface::class, PricingRepository::class);
        $this->app->singleton(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->singleton(CourseRepositoryInterface::class, CourseRepository::class);        
        $this->app->singleton(LearningProgressService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add this to preserve flash messages for an extra request
        if (session('success')) {
            session()->flash('success', session('success'));
        }
        
        Transaction::observe(TransactionObserver::class);

        // // Membagikan variabel $user ke semua view yang menggunakan 'navigation-auth'
        // View::composer('components.navigation-auth', function ($view) {
        //     $view->with('user', Auth::user());
        // });
    }
}
