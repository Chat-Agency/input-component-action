<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface ErrorAttributes
{
    public function setErrorAttributes(Closure|array $errorAttributes): static;

    public function getErrorAttributes(): Closure|array|null;
}
