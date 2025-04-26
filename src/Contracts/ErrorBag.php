<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

interface ErrorBag
{
    public function setErrors(array $errors): static;

    public function resolve(InputInterface $input, InputComponentRecipe $recipe): ?string;
}
