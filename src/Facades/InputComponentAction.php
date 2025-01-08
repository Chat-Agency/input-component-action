<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ChatAgency\InputComponentAction\InputComponentAction
 */
class InputComponentAction extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ChatAgency\InputComponentAction\InputComponentAction::class;
    }
}
