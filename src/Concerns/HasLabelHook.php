<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasLabelHook
{
    private ?Closure $labelHook = null;

    public function setLabelHook(Closure $labelHook): static
    {
        $this->labelHook = $labelHook;

        return $this;
    }

    public function getLabelHook(): ?Closure
    {
        return $this->labelHook;
    }
}
