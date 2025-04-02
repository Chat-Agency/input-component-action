<?php

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

interface ComponentComposer
{
    public function build(): BackendComponent;

    public function resolveCallback(BackendComponent $component, InputComponentRecipe $recipe, ?string $value = null): BackendComponent;
}