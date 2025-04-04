<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait isAttributeBag
{
    private Closure|array $wrapperAttributes = [];

    private Closure|array $inputAttributes = [];
    
    private Closure|array $labelAttributes = [];

    private Closure|array $errorAttributes = [];

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
    public function getWrapperAttributes(): Closure|array
    {
        return $this->wrapperAttributes;
    }

    public function getInputAttributes(): Closure|array
    {
        return $this->inputAttributes;
    }

    public function getLabelAttributes(): Closure|array
    {
        return $this->labelAttributes;
    }

    public function getErrorAttributes(): Closure|array
    {
        return $this->errorAttributes;
    }
}
