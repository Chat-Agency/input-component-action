<?php

namespace ChatAgency\InputComponentAction\Contracts;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

interface InputGroup
{
    public function inject(
        InputInterface $input,
        ThemeManager $themeManager,
        ?ThemeBag $defaultThemeBag = null,
        ?string $value = null,
        ?string $error = null,
    ): static;
    
    public function getGroup(): BackendComponent;

}
