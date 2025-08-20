<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

trait HasWrapperBuilder
{
    private ?StaticBuilder $wrapperBuilder = null;

    public function setWrapperBuilder(StaticBuilder $wrapperBuilder): static
    {
        $this->wrapperBuilder = $wrapperBuilder;

        return $this;
    }

    public function getWrapperBuilder(): ?StaticBuilder
    {
        return $this->wrapperBuilder;
    }
}
