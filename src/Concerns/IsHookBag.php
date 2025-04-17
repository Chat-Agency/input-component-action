<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait IsHookBag
{
    private ?Closure $wrapperHook = null;

    private ?Closure $inputHook = null;

    private ?Closure $labelHook = null;

    private ?Closure $errorHook = null;

    public function setWrapperHook(Closure $wrapperHook): static
    {
        $this->wrapperHook = $wrapperHook;

        return $this;
    }

    public function setInputHook(Closure $inputHook): static
    {
        $this->inputHook = $inputHook;

        return $this;
    }

    public function setLabelHook(Closure $labelHook): static
    {
        $this->labelHook = $labelHook;

        return $this;
    }

    public function setErrorHook(Closure $errorHook): static
    {
        $this->errorHook = $errorHook;

        return $this;
    }

    public function getWrapperHook(): ?Closure
    {
        return $this->wrapperHook;
    }

    public function getInputHook(): ?Closure
    {
        return $this->inputHook;
    }

    public function getLabelHook(): ?Closure
    {
        return $this->labelHook;
    }

    public function getErrorHook(): ?Closure
    {
        return $this->errorHook;
    }
}
