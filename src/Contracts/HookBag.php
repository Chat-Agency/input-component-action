<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface HookBag
{
    public function setInputHook(Closure $inputHook): static;

    public function getInputHook(): ?Closure;
}
