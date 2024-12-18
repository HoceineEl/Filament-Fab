<?php

namespace HoceineEl\Fab\Livewire;

use App\Filament\Academy\Resources\CampResource;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use ReflectionClass;
use ReflectionMethod;

class FloatingActionButton extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function createAction(): Action
    {
        return Action::make('create')
            ->label(__('actions.create_new'))
            ->icon('heroicon-o-plus')
            ->slideOver()
            ->form([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }
    public function showModalAction(): Action
    {
        return Action::make('showModal')
            ->label(__('Show Modal'))
            ->icon('tabler-message-circle-plus')
            ->modal()
            ->form([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function render()
    {
        return view('filament-fab::components.floating-action-button', [
            'actions' => $this->getActions()
        ]);
    }

    public function getActions(): array
    {
        $reflection = new ReflectionClass($this);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $actions = collect($methods)
            ->filter(fn(ReflectionMethod $method) => str_ends_with($method->getName(), 'Action'))
            ->filter(fn(ReflectionMethod $method) => $method->getName() !== 'getActions')
            ->filter(fn(ReflectionMethod $method) => $method->getDeclaringClass()->getName() === self::class)
            ->filter(fn(ReflectionMethod $method) => !in_array($method->getName(), get_class_methods(InteractsWithActions::class)))
            ->filter(fn(ReflectionMethod $method) => !in_array($method->getName(), get_class_methods(InteractsWithForms::class)))
            ->map(fn(ReflectionMethod $method) => $this->{$method->getName()}())
            ->map(
                fn(Action $action) =>
                $action
                    ->iconButton()
                    ->extraAttributes([
                        'class' => 'menu-item'
                    ])
                    ->tooltip($action->getLabel())
            )
            ->toArray();

        return $actions;
    }
}
