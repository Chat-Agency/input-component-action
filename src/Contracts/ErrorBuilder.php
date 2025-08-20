<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

interface ErrorBuilder
{
    public function setErrorBuilder(StaticBuilder $errorBuilder): static;

    public function getErrorBuilder(): ?StaticBuilder;
}
