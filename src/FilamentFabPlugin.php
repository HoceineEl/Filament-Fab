<?php

namespace HoceineEl\Fab;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Support\Facades\FilamentAsset;
use Filament\View\PanelsRenderHook;
use HoceineEl\Fab\Concerns\HasRenderHooksScopes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;

class FilamentFabPlugin implements Plugin
{
    use HasRenderHooksScopes;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-fab';
    }

    public function register(Panel $panel): void
    {
        // // Don't register in production if disabled in config
        // if (App::environment('production') && !Config::get('filament-fab.enable_in_production', true)) {
        //     return;
        // }

        // Only register if user is authenticated

        $panel->renderHook(
            PanelsRenderHook::BODY_END,
            fn(): string => Blade::render('@livewire(\'floating-action-button\')'),
            // scopes: $this->getRenderHooksScopes()
        );

        // Register assets
        FilamentAsset::register([
            \Filament\Support\Assets\Css::make('filament-fab-styles', __DIR__ . '/../resources/dist/filament-fab.css'),
            \Filament\Support\Assets\Js::make('filament-fab-scripts', __DIR__ . '/../dist/js/filament-fab.js'),
        ], package: 'filament-fab');
    }

    public function boot(Panel $panel): void
    {
        // // Register manager singleton
        // app()->singleton(FabManager::class, function () {
        //     return new FabManager();
        // });
    }
}
