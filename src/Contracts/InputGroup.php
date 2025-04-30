<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

interface InputGroup
{
    public function inject(
        InputInterface $input,
        InputComponentRecipe $recipe,
        ThemeManager $themeManager,
        ValueBag $values,
        ErrorBag $errors,
        ?ThemeBag $defaultThemeBag = null,
    ): static;

    public function getGroup(): BackendComponent|ContentComponent;

    public function setParent(InputInterface $parent): static;
}
