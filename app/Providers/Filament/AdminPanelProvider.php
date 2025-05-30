<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->sidebarCollapsibleOnDesktop()
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->navigationItems([
                NavigationItem::make('Job Opening')
                    ->icon('heroicon-o-briefcase')
                    ->group('Recruitment'),
                NavigationItem::make('Job Description')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->group('Recruitment'),
                NavigationItem::make('Application')
                    ->icon('heroicon-o-clock')
                    ->group('Recruitment'),
                NavigationItem::make('CV Database')
                    ->icon('heroicon-o-list-bullet')
                    ->group('Recruitment'),
                NavigationItem::make('Standard Resume')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->group('Recruitment'),
                NavigationItem::make('Tests')
                    ->icon('heroicon-o-book-open')
                    ->group('Recruitment'),
                NavigationItem::make('Screening')
                    ->icon('heroicon-o-document')
                    ->group('Recruitment'),
                NavigationItem::make('Recruitment Status')
                    ->icon('heroicon-o-funnel')
                    ->group('Recruitment'),
            ])
            ->colors([
                'primary' => [
                    50 => '#f9f4f4',
                    100 => '#f2eae8',
                    200 => '#dfcac7',
                    300 => '#cbaaa5',
                    400 => '#a46b61',
                    500 => '#7D2B1D',
                    600 => '#71271a',
                    700 => '#5e2016',
                    800 => '#4b1a11',
                    900 => '#3d150e'
                ],
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->maxContentWidth(MaxWidth::Full)
            ->passwordReset()
            ->darkMode(false)
            // ->brandLogo(asset('images/logoh.jpg'))
            ->brandLogo(fn() => view('filament.admin.logo'))
            // ->registration()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentEditProfilePlugin::make()->setIcon('heroicon-o-user')
                    ->shouldShowBrowserSessionsForm(false)
                    ->shouldShowDeleteAccountForm(false)->setSort(4)
                    ->setNavigationGroup("Settings")
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars', // image will be stored in 'storage/app/public/avatars
                        rules: 'mimes:jpeg,png|max:1024' //only accept jpeg and png files with a maximum size of 1MB
                    )
            ])
            ->navigationGroups([
                NavigationGroup::make()->label(__('Administration'))->collapsed(),
                NavigationGroup::make()->label(__('Intermediano Companies'))->collapsed(),
                NavigationGroup::make()->label(__('Investments'))->collapsed(),
                NavigationGroup::make()->label(__('Recruitment'))->collapsed(),
                NavigationGroup::make()->label(__('Sales')),
                NavigationGroup::make()->label(__('Settings'))->collapsed(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters');
    }
}
