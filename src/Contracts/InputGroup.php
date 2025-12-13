<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

interface InputGroup
{
    public function inject(
        InputInterface $input,
        InputComponentRecipe $recipe,
        ThemeManager $themeManager,
        InputGroup $defaultInputGroup,
        ValueManager $values,
        ErrorManager $errors,
        ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null,
    ): static;

    public function getGroup(): BackendComponent|ContentComponent;

    public function setParent(InputInterface $parent): static;
}
