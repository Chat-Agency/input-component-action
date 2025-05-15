<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasErrorHook
{
    private ?Closure $errorHook = null;

    public function setErrorHook(Closure $errorHook): static
    {
        $this->errorHook = $errorHook;

        return $this;
    }

    public function getErrorHook(): ?Closure
    {
        return $this->errorHook;
    }
}
