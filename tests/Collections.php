<?php

declare(strict_types=1);

namespace Tests;

use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextareaInput;
use Chatagency\CrudAssistant\Inputs\TextInput;

class Collections
{
    public  static function simple(): InputCollection
    {
        return CrudAssistant::make([
            new TextInput('name', 'Name'),
            (new TextInput('email', 'Email'))
                ->setType('email'),
            new TextInput('phone', 'Phone'),
            new TextareaInput('description', 'Description'),
        ]);
    }
}
