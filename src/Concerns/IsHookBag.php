<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait IsHookBag
{
    private ?Closure $inputHook = null;

    public function setInputHook(Closure $inputHook): static
    {
        $this->inputHook = $inputHook;

        return $this;
    }

    public function getInputHook(): ?Closure
    {
        return $this->inputHook;
    }
}
