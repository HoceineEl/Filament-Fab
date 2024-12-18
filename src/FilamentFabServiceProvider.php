<?php

namespace HoceineEl\Fab;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use HoceineEl\Fab\Livewire\FloatingActionButton;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFabServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-fab')
            ->hasTranslations()
            ->hasViews();
    }

    public function packageBooted()
    {
        FilamentAsset::register(
            assets: [
                Css::make(
                    id: 'filament-fab',
                    path: __DIR__ . '/../dist/css/filament-fab.css'
                ),
            ],
            package: 'hoceineel/filament-fab'
        );

        Livewire::component(
            name: 'floating-action-button',
            class: FloatingActionButton::class
        );
    }
}
