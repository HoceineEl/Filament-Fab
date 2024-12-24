<?php

namespace HoceineEl\Fab;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\View\PanelsRenderHook;
use HoceineEl\Fab\Concerns\HasRenderHooksScopes;
use Illuminate\Support\Facades\Blade;


class FilamentFabPlugin implements Plugin
{
    use HasRenderHooksScopes;
    public static function make()
    {
        return app(static::class);
    }


    public function getId(): string
    {
        return 'filament-fab';
    }

    public function register(Panel $panel): void
    {
        if (auth()->check()) {
            $panel->renderHook(
                PanelsRenderHook::BODY_END,
                fn(): string => Blade::render('@livewire(\'floating-action-button\')'),
                scopes: $this->getRenderHooksScopes()
            );
        }
    }



    public function boot(Panel $panel): void
    {
        //
    }
}
