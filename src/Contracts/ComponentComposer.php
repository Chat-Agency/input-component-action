<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;

interface ComponentComposer
{
    public function setParent(InputInterface $parent): static;

    public function build(): BackendComponent|ContentComponent|ThemeComponent;
}
