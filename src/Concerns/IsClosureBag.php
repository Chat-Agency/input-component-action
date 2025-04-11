<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait IsClosureBag
{
    private ?Closure $wrapperClosure = null;

    private ?Closure $inputClosure = null;

    private ?Closure $labelClosure = null;

    private ?Closure $errorClosure = null;

    public function setWrapperClosure(Closure $wrapperClosure): static
    {
        $this->wrapperClosure = $wrapperClosure;

        return $this;
    }

    public function setInputClosure(Closure $inputClosure): static
    {
        $this->inputClosure = $inputClosure;

        return $this;
    }

    public function setLabelClosure(Closure $labelClosure): static
    {
        $this->labelClosure = $labelClosure;

        return $this;
    }

    public function setErrorClosure(Closure $errorClosure): static
    {
        $this->errorClosure = $errorClosure;

        return $this;
    }

    public function getWrapperClosure(): ?Closure
    {
        return $this->wrapperClosure;
    }

    public function getInputClosure(): ?Closure
    {
        return $this->inputClosure;
    }

    public function getLabelClosure(): ?Closure
    {
        return $this->labelClosure;
    }

    public function getErrorClosure(): ?Closure
    {
        return $this->errorClosure;
    }
}
