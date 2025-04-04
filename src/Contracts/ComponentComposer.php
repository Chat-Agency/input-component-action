<?php

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;
use BackedEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

interface ComponentComposer
{
    public function build(): BackendComponent;

    public function resolveComponentClosure(BackendComponent $component, ?Closure $closure, InputInterface $input, BackedEnum $type): BackendComponent;
}