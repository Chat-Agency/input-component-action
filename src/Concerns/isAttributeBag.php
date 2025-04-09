<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait isAttributeBag
{
    private Closure|array|null $wrapperAttributes = null;

    private Closure|array|null $inputAttributes = null;
    
    private Closure|array|null $labelAttributes = null;

    private Closure|array|null $errorAttributes = null;

    public function setWrapperAttributes(Closure|array $wrapperAttributes): static
    {
        $this->wrapperAttributes = $wrapperAttributes;

        return $this;
    }

    public function setInputAttributes(Closure|array $inputAttributes): static
    {
        $this->inputAttributes = $inputAttributes;

        return $this;
    }

    public function setLabelAttributes(Closure|array $labelAttributes): static
    {
        $this->labelAttributes = $labelAttributes;

        return $this;
    }

    public function setErrorAttributes(Closure|array $errorAttributes): static
    {
        $this->errorAttributes = $errorAttributes;

        return $this;
    }
    public function getWrapperAttributes(): Closure|array|null
    {
        return $this->wrapperAttributes;
    }

    public function getInputAttributes(): Closure|array|null
    {
        return $this->inputAttributes;
    }

    public function getLabelAttributes(): Closure|array|null
    {
        return $this->labelAttributes;
    }

    public function getErrorAttributes(): Closure|array|null
    {
        return $this->errorAttributes;
    }
}
