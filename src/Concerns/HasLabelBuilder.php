<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

trait HasLabelBuilder
{
    private ?StaticBuilder $labelBuilder = null;

    public function setLabelBuilder(StaticBuilder $labelBuilder): static
    {
        $this->labelBuilder = $labelBuilder;

        return $this;
    }

    public function getLabelBuilder(): ?StaticBuilder
    {
        return $this->labelBuilder;
    }
}
