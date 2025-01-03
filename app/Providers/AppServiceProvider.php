<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
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
        
	URL::forceScheme('https');

        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make(__('Lead Registration'))
                    ->url(route('filament.admin.resources.leads.create'))
                    ->icon('heroicon-o-check-circle')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.leads.create'))
                    ->activeIcon('heroicon-s-check-circle')
                    ->group('Sales')
                    ->sort(1),
                NavigationItem::make(__('Company Registration'))
                    ->url(route('filament.admin.resources.companies.create'))
                    ->icon('heroicon-o-pencil-square')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.companies.create'))
                    ->activeIcon('heroicon-s-pencil-square')
                    ->group('Sales')
                    ->sort(4),
            ]);
        });
    }
}
