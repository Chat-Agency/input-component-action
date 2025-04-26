<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use Chatagency\CrudAssistant\Contracts\InputInterface;

interface InputGroup
{
    public function inject(
        InputInterface $input,
        ThemeManager $themeManager,
        ValueBag $values,
        ErrorBag $errors,
        ?ThemeBag $defaultThemeBag = null,
    ): static;

    public function getGroup(): BackendComponent|ContentComponent;

    public function setParent(InputInterface $parent): static;
}
