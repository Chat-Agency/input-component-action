<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Bags\DefaultErrorBag;
use ChatAgency\InputComponentAction\Bags\DefaultValueBag;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;

interface InputGroup
{
    public function inject(
        InputInterface $input,
        ThemeManager $themeManager,
        DefaultValueBag $values,
        DefaultErrorBag $errors,
        ?ThemeBag $defaultThemeBag = null,
    ): static;

    public function getGroup(): BackendComponent|ContentComponent;
}
