<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

interface LabelBuilder
{
    public function setLabelBuilder(StaticBuilder $labelBuilder): static;

    public function getLabelBuilder(): ?StaticBuilder;
}
