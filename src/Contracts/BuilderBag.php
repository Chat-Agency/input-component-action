<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

interface BuilderBag
{
    public function setInputBuilder(StaticBuilder $inputBuilder): static;

    public function getInputBuilder(): ?StaticBuilder;
}
