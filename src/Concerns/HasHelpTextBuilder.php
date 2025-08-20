<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

trait HasHelpTextBuilder
{
    private ?StaticBuilder $helpTextBuilder = null;

    public function setHelpTextBuilder(StaticBuilder $helpTextBuilder): static
    {
        $this->helpTextBuilder = $helpTextBuilder;

        return $this;
    }

    public function getHelpTextBuilder(): ?StaticBuilder
    {
        return $this->helpTextBuilder;
    }
}
