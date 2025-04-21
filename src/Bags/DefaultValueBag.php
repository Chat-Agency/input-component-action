<?php

namespace ChatAgency\InputComponentAction\Bags;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;

class DefaultValueBag
{
    public function __construct(
        private array $values,
        private ?object $model,
    ) 
    {
    }

    public function resolve(InputInterface $input, InputComponentRecipe $recipe = null): ?string
    {
        $values = $this->values;
        $model = $this->model;
        
        $name = Support::getName($input);

        $defaultValue = $values[$name] ?? null;
        $modelValue = null;
        $recipeValue = null;

        if($model) {
            $modelValue = $model->{$name} ?? null;
        }

        if($recipe) {
            $recipeValue = $recipe->inputValue;
        }
        $value = null;

        if (Support::isClosure($recipeValue)) {
            $value = $recipeValue($input, $values);
        } else {
            $value = $recipeValue;
        }

        return $value ?? $defaultValue ?? $modelValue ?? null;
    }
}
