<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;
use BackedEnum;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

trait isComposer
{
    public  static function resolveInputValue(InputComponentRecipe $recipe, ?string $value = null) : ?string
    {
        return (!is_null($recipe->inputValue)) ? $recipe->inputValue : $value;
    }
    public function resolveWrapperType(?InputComponentRecipe $recipe) : string|ComponentEnum
    {
        return $recipe->wrapperType ?? ComponentEnum::DIV;
    }
    public function resolveLabelType(?InputComponentRecipe $recipe) : string|ComponentEnum
    {
        return $recipe->labelType ?? ComponentEnum::LABEL;
    }

    public function resolveInputType(?InputComponentRecipe $recipe) : string|ComponentEnum
    {
        return $recipe->inputType ?? ComponentEnum::TEXT_INPUT;
    }

    public function resolveErrorType(?InputComponentRecipe $recipe) : string|ComponentEnum
    {
        return $recipe->errorType ?? ComponentEnum::DIV;
    }

    public function resolveComponentClosure(BackendComponent $component, ?Closure $closure, InputInterface $input, BackedEnum $type): BackendComponent
    {
        if(Support::isClosure($closure)) {
            /** @var array $closure */
            return $closure($component, $input, $type);
        }

        return $component;
    }

}
