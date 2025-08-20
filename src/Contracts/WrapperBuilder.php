<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\StaticBuilder;

interface WrapperBuilder
{
    public function setWrapperBuilder(StaticBuilder $wrapperBuilder): static;

    public function getWrapperBuilder(): ?StaticBuilder;
}
