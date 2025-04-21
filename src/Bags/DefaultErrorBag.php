<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;

class DefaultErrorBag
{
    public function __construct(
        public readonly array $errors
    ) {}

    public function resolve(InputInterface $input, ?InputComponentRecipe $recipe = null): ?string
    {

        $errors = $this->errors;

        $name = Support::getName($input);
        $recipe = Support::getRecipe($input);

        $recipeError = $recipe->inputError;
        $errorDefault = $errors[$name] ?? null;
        $error = null;

        if (Support::isClosure($recipeError)) {
            $error = $recipeError($input, $errors);
        } else {
            $error = $recipeError;
        }

        /**
         * If multiple errors
         */
        if (is_array($errorDefault)) {
            $reversed = array_reverse(array: $errorDefault);
            $errorDefault = array_pop(array: $reversed);
        }

        return $error ?? $errorDefault ?? null;
    }
}
