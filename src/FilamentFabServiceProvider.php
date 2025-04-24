<?php

namespace HoceineEl\Fab;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use HoceineEl\Fab\FabManager;
use HoceineEl\Fab\Livewire\FloatingActionButton;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFabServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-fab';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasTranslations()
            ->hasViews()
            ->hasAssets()
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->askToStarRepoOnGitHub('hoceineel/filament-fab');
            });
    }

    public function packageBooted()
    {
        // Register the fab manager singleton
        $this->app->singleton(FabManager::class, function () {
            return new FabManager();
        });

        // Register facade
        $loader = AliasLoader::getInstance();
        $loader->alias('Fab', \HoceineEl\Fab\Facades\Fab::class);

        // Register assets
        FilamentAsset::register([
            Css::make('filament-fab-styles', __DIR__ . '/../resources/dist/filament-fab.css')
                ->loadedOnRequest(),
            Js::make('filament-fab-scripts', __DIR__ . '/../dist/js/filament-fab.js')
                ->loadedOnRequest(),
        ], package: 'hoceineel/filament-fab');

        // Register Livewire component
        Livewire::component(
            name: 'floating-action-button',
            class: FloatingActionButton::class
        );
    }

    public function packageRegistered(): void {}
}
