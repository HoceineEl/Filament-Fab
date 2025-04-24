<?php

namespace App\Providers;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use HoceineEl\Fab\Facades\Fab;
use Illuminate\Support\ServiceProvider;

class FilamentFabActionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register a simple action with a closure
        Fab::registerAction('createPost', function () {
            return Action::make('createPost')
                ->label('New Post')
                ->icon('heroicon-o-document-plus')
                ->color('success')
                ->url(route('filament.admin.resources.posts.create'))
                ->openUrlInNewTab();
        });

        // Register an action with a form
        Fab::registerAction('quickSearch', function () {
            return Action::make('quickSearch')
                ->label('Search')
                ->icon('heroicon-o-magnifying-glass')
                ->color('info')
                ->form([
                    TextInput::make('query')
                        ->label('Search query')
                        ->placeholder('Enter search term...')
                        ->required(),
                ])
                ->action(function (array $data) {
                    // Redirect to search results or process the search
                    return redirect()->route('filament.admin.resources.posts.index', [
                        'tableSearch' => $data['query'],
                    ]);
                });
        });

        // Register multiple actions at once
        Fab::registerActions([
            'settings' => Action::make('settings')
                ->label('Settings')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('gray')
                ->url(route('filament.admin.pages.settings')),

            'reports' => Action::make('reports')
                ->label('Reports')
                ->icon('heroicon-o-chart-bar')
                ->color('warning')
                ->url(route('filament.admin.pages.reports')),
        ]);
    }
}
