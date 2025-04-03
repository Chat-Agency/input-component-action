<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;
use BackedEnum;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

trait isComposer
{
    public function resolveInputType(InputComponentRecipe $recipe) : string|ComponentEnum
    {
        return $recipe->inputType ?? ComponentEnum::TEXT_INPUT;
    }
    
    public function resolveCallback(BackendComponent $component, InputComponentRecipe $recipe, ?string $value = null): BackendComponent
    {
        

        return $component;
    }

}
