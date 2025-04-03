<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait isThemeBag
{
    private Closure|array $wrapperTheme = [];

    private Closure|array $inputTheme = [];
    
    private Closure|array $labelTheme = [];

    private Closure|array $errorTheme = [];

    public function setWrapperTheme(Closure|array $wrapperTheme): static
    {
        $this->wrapperTheme = $wrapperTheme;

        return $this;
    }

    public function setInputTheme(Closure|array $inputTheme): static
    {
        $this->inputTheme = $inputTheme;

        return $this;
    }

    public function setLabelTheme(Closure|array $labelTheme): static
    {
        $this->labelTheme = $labelTheme;

        return $this;
    }

    public function setErrorTheme(Closure|array $errorTheme): static
    {
        $this->errorTheme = $errorTheme;

        return $this;
    }
    public function getWrapperTheme(): Closure|array
    {
        return $this->wrapperTheme;
    }

    public function getInputTheme(): Closure|array
    {
        return $this->inputTheme;
    }

    public function getLabelTheme(): Closure|array
    {
        return $this->labelTheme;
    }

    public function getErrorTheme(): Closure|array
    {
        return $this->errorTheme;
    }

}
