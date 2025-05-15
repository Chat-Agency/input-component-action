<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface WrapperTheme
{
    public function setWrapperTheme(Closure|array $wrapperTheme): static;

    public function getWrapperTheme(): Closure|array|null;
}
