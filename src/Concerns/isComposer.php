<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;
use BackedEnum;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\ThemeUtil;
use ChatAgency\InputComponentAction\InputComponentAction;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
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
