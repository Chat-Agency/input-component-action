<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;

class DefaultValueBag
{
    public function __construct(
        private array $values,
        private ?object $model,
    ) {}

    public function resolve(InputInterface $input, InputComponentRecipe $recipe, bool $ignoreRecipeValue = false): ?string
    {
        $values = $this->values;
        $model = $this->model;

        $name = Support::getName($input);

        $defaultValue = $values[$name] ?? null;
        $recipeValue = $recipe->inputValue;
        $modelValue = null;

        if ($model) {
            $modelValue = $model->{$name} ?? null;
        }

        $value = null;

        if (! $ignoreRecipeValue) {
            if (Support::isClosure($recipeValue)) {
                $value = $recipeValue($input, $values);
            } else {
                $value = $recipeValue;
            }
        }

        return $value ?? $defaultValue ?? $modelValue ?? null;
    }
}
