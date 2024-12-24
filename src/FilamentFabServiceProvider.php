<?php

namespace HoceineEl\Fab;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use HoceineEl\Fab\Livewire\FloatingActionButton;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFabServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-fab')
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->askToStarRepoOnGitHub('hoceineel/filament-fab');
            })
            ->hasViews();
    }

    public function packageBooted()
    {
        FilamentAsset::register([
            Css::make('filament-fab-css', __DIR__ . '/../resources/dist/filament-fab.css'),
        ], package: 'hoceineel/filament-fab');
        Livewire::component(
            name: 'floating-action-button',
            class: FloatingActionButton::class
        );
    }
}
