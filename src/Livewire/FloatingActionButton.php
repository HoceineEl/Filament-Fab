<?php

namespace HoceineEl\Fab\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use HoceineEl\Fab\FabManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;
use Livewire\Component;

class FloatingActionButton extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function render()
    {
        return view('filament-fab::components.floating-action-button', [
            'actions' => $this->getActions(),
            'position' => Config::get('filament-fab.default_position', 'bottom-right'),
            'rememberPosition' => Config::get('filament-fab.remember_position', true),
        ]);
    }

    public function getActions(): array
    {
        // Get custom actions from the manager
        $customActions = collect(FabManager::getCustomActions())->map(function ($action, $name) {
            if ($action instanceof \Closure) {
                $action = $action();
            }

            if (!$action instanceof Action) {
                return null;
            }

            return $action->iconButton()
                ->extraAttributes(['class' => 'menu-item'])
                ->tooltip($action->getLabel());
        })->filter()->values()->toArray();

        // Return custom actions only
        return $customActions;
    }
}
