<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;
use BackedEnum;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\InputComponentAction\Bags\DefaultThemeBag;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Groups\DefaultInputGroup;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

trait isComposer
{
    
    public function resolveGroup(InputInterface $input): BackendComponent
    {
        $recipe = Support::getRecipe($input);
        
        $group = $recipe->inputGroup ?? $this->defaultInputGroup ?? new DefaultInputGroup;
        
        $group = $group->inject(
            input: $input,
            themeManager: $this->themeManager,
            defaultThemeBag: new DefaultThemeBag,
            value: $this->value,
            error: $this->error,
        );

        return $group->getGroup();

    }   
    
    public static function resolveInputValue(InputComponentRecipe $recipe, ?string $value = null) : ?string
    {
        return (!is_null($recipe->inputValue)) ? $recipe->inputValue : $value;
    }
    
    public static function resolveInputName(InputInterface $input, ?array $attributes = null) : ?string
    {
        $recipe = Support::getRecipe($input);
        $attributes ??= $recipe?->attributeBag?->getInputAttributes() ?? null;

        return $attributes['name'] ?? $input->getName();
    }
    
    public static function resolveInputId(InputInterface $input, ?array $attributes = null) : ?string
    {
        $recipe = Support::getRecipe($input);
        $attributes ??= $recipe?->attributeBag?->getInputAttributes() ?? null;

        return $attributes['id'] ?? $input->getName();
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
