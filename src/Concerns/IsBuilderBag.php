<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

trait IsBuilderBag
{
    private ?StaticBuilder $inputBuilder = null;

    public function setInputBuilder(StaticBuilder $inputBuilder): static
    {
        $this->inputBuilder = $inputBuilder;

        return $this;
    }

    public function getInputBuilder(): ?StaticBuilder
    {
        return $this->inputBuilder;
    }
}
