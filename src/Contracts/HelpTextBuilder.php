<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

interface HelpTextBuilder
{
    public function setHelpTextBuilder(StaticBuilder $helpTextBuilder): static;

    public function getHelpTextBuilder(): ?StaticBuilder;
}
