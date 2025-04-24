<?php

namespace HoceineEl\Fab;

use Filament\Actions\Action;
use Closure;

class FabManager
{
    /**
     * Custom actions registered by the user
     */
    protected static array $customActions = [];

    /**
     * Register a custom action for the FAB
     *
     * @param string $name Unique action identifier
     * @param Closure|Action $action Closure that returns an Action or the Action itself
     * @return void
     */
    public static function registerAction(string $name, Closure|Action $action): void
    {
        static::$customActions[$name] = $action;
    }

    /**
     * Register multiple custom actions for the FAB
     *
     * @param array $actions Array of actions with name as key and Closure|Action as value
     * @return void
     */
    public static function registerActions(array $actions): void
    {
        foreach ($actions as $name => $action) {
            static::registerAction($name, $action);
        }
    }

    /**
     * Get all registered custom actions
     *
     * @return array
     */
    public static function getCustomActions(): array
    {
        return static::$customActions;
    }

    /**
     * Get a specific custom action by name
     *
     * @param string $name
     * @return Closure|Action|null
     */
    public static function getCustomAction(string $name): Closure|Action|null
    {
        return static::$customActions[$name] ?? null;
    }

    /**
     * Remove a custom action
     *
     * @param string $name
     * @return void
     */
    public static function removeAction(string $name): void
    {
        if (isset(static::$customActions[$name])) {
            unset(static::$customActions[$name]);
        }
    }
}
