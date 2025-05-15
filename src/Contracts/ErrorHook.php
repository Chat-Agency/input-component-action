<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface ErrorHook
{
    public function setErrorHook(Closure $errorHook): static;

    public function getErrorHook(): ?Closure;
}
