<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface WrapperAttributes
{
    public function setWrapperAttributes(Closure|array $wrapperAttributes): static;

    public function getWrapperAttributes(): Closure|array|null;
}
