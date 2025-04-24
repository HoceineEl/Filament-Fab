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
use Illuminate\Support\Facades\Blade;
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
        // Make sure they're inlined so they're always available
        FilamentAsset::register([
            Css::make('filament-fab-styles', __DIR__ . '/../resources/dist/filament-fab.css'),
            Js::make('filament-fab-scripts', __DIR__ . '/../dist/js/filament-fab.js'),
        ], package: 'hoceineel/filament-fab');

        // Register Livewire component
        Livewire::component(
            name: 'floating-action-button',
            class: FloatingActionButton::class
        );

        // Publish assets as public files for direct access
        $this->publishes([
            __DIR__ . '/../resources/dist/filament-fab.css' => public_path('vendor/filament-fab/filament-fab.css'),
            __DIR__ . '/../dist/js/filament-fab.js' => public_path('vendor/filament-fab/filament-fab.js'),
        ], 'filament-fab-assets');

        // Add direct script to the blade service provider for Alpine.js components
        Blade::directive('filamentFabScripts', function () {
            return <<<'HTML'
            <script src="{{ asset('vendor/filament-fab/filament-fab.js') }}"></script>
            HTML;
        });

        Blade::directive('filamentFabStyles', function () {
            return <<<'HTML'
            <link rel="stylesheet" href="{{ asset('vendor/filament-fab/filament-fab.css') }}">
            HTML;
        });
    }

    public function packageRegistered(): void {}
}
