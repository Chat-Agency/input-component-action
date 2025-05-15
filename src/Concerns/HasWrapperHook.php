<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasWrapperHook
{
    private ?Closure $wrapperHook = null;

    public function setWrapperHook(Closure $wrapperHook): static
    {
        $this->wrapperHook = $wrapperHook;

        return $this;
    }

    public function getWrapperHook(): ?Closure
    {
        return $this->wrapperHook;
    }
}
