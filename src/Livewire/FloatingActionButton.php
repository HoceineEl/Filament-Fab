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
        $themeConfig = Config::get('filament-fab.theme', []);

        // Default theme settings
        $defaultTheme = [
            'button_size' => '60px',
            'menu_item_size' => '40px',
            'menu_width' => '320px',
            'menu_spacing' => '16px',
            'animation_speed' => '0.3s',
            'animation_easing' => 'cubic-bezier(0.4, 0, 0.2, 1)',
        ];

        // Default color settings
        $defaultColors = [
            'button_bg' => '#3b82f6',
            'button_bg_hover' => '#2563eb',
            'button_bg_active' => '#1d4ed8',
            'button_text' => '#ffffff',
            'menu_bg' => '#ffffff',
            'menu_bg_dark' => '#1f2937',
            'menu_text' => '#4b5563',
            'menu_text_dark' => '#e5e7eb',
            'menu_hover' => '#f3f4f6',
            'menu_hover_dark' => '#374151',
            'menu_item_accent' => '#3b82f6',
            'menu_item_accent_dark' => '#60a5fa',
            'tooltip_bg' => '#111827',
            'tooltip_bg_dark' => '#374151',
            'tooltip_text' => '#ffffff',
        ];

        // Merge user settings with defaults
        $theme = array_merge($defaultTheme, $themeConfig);
        $colors = array_merge($defaultColors, $themeConfig['colors'] ?? []);
        $theme['colors'] = $colors;

        return view('filament-fab::components.floating-action-button', [
            'actions' => $this->getActions(),
            'position' => Config::get('filament-fab.default_position', 'bottom-right'),
            'rememberPosition' => Config::get('filament-fab.remember_position', true),
            'theme' => $theme,
            'showTooltip' => Config::get('filament-fab.show_tooltip', true),
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
