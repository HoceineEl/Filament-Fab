<?php

namespace HoceineEl\Fab\Facades;

use HoceineEl\Fab\FabManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void registerAction(string $name, \Closure|\Filament\Actions\Action $action)
 * @method static void registerActions(array $actions)
 * @method static array getCustomActions()
 * @method static \Closure|\Filament\Actions\Action|null getCustomAction(string $name)
 * @method static void removeAction(string $name)
 * 
 * @see \HoceineEl\Fab\FabManager
 */
class Fab extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FabManager::class;
    }
}
