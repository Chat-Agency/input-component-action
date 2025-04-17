<?php

declare(strict_types=1);

namespace Tests;

use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\DefaultInput;

class Collections
{
    public static function simple(): InputCollection
    {
        return CrudAssistant::make([
            new DefaultInput('name', 'Name'),
            new DefaultInput('email', 'Email'),
            new DefaultInput('phone', 'Phone'),
            new DefaultInput('description', 'Description'),
        ]);
    }
}
