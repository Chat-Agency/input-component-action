<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Contracts\ValueBag;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;

final class DefaultValueBag implements ValueBag
{
    private ?array $values = [];

    private ?object $model = null;

    public function setValues(array $values): static
    {
        $this->values = $values;

        return $this;
    }

    public function setModel(?object $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function resolve(InputInterface $input, InputComponentRecipe $recipe, bool $ignoreRecipeValue = false): string|int|array|null
    {
        $values = $this->values;
        $model = $this->model;

        $name = $input->getName();

        if(array_key_exists(key: $name, array: $values)) {
            return $values[$name];
        };
        
        $recipeValue = $recipe->inputValue;
        $modelValue = null;

        $modelValue = $model?->{$name} ?? null;

        $value = null;

        if (! $ignoreRecipeValue) {
            if (Support::isClosure($recipeValue)) {
                $value = $recipeValue($input, $values, $model);
            } else {
                $value = $recipeValue;
            }
        }

        return $value ?? $defaultValue ?? $modelValue ?? null;
    }
}
