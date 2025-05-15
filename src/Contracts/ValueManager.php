<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

interface ValueManager
{
    public function setValues(array $values): static;

    public function setModel(object $model): static;

    public function resolve(InputInterface $input, InputComponentRecipe $recipe, bool $ignoreRecipeValue = false): string|int|array|null;
}
