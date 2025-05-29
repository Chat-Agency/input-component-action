<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Managers;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Contracts\ErrorManager;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;

final class DefaultErrorManager implements ErrorManager
{
    private array $errors = [];

    public function setErrors(array $errors): static
    {
        $this->errors = $errors;

        return $this;
    }

    public function resolve(InputInterface $input, InputComponentRecipe $recipe): ?string
    {

        $errors = $this->errors;

        $name = $input->getName();

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
