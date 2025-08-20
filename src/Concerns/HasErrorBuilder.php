<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

trait HasErrorBuilder
{
    private ?StaticBuilder $errorBuilder = null;

    public function setErrorBuilder(StaticBuilder $errorBuilder): static
    {
        $this->errorBuilder = $errorBuilder;

        return $this;
    }

    public function getErrorBuilder(): ?StaticBuilder
    {
        return $this->errorBuilder;
    }
}
