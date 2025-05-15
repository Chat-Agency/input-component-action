<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasHelpTextHook
{
    private ?Closure $helpTextHook = null;

    public function setHelpTextHook(Closure $helpTextHook): static
    {
        $this->helpTextHook = $helpTextHook;

        return $this;
    }

    public function getHelpTextHook(): ?Closure
    {
        return $this->helpTextHook;
    }
}
