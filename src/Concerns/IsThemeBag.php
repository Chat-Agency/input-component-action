<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait IsThemeBag
{
    private Closure|array|null $wrapperTheme = null;

    private Closure|array|null $inputTheme = null;

    private Closure|array|null $labelTheme = null;

    private Closure|array|null $helpTextTheme = null;

    private Closure|array|null $errorTheme = null;

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

    public function setHelpTextTheme(Closure|array $helpTextTheme): static
    {
        $this->helpTextTheme = $helpTextTheme;

        return $this;
    }

    public function setErrorTheme(Closure|array $errorTheme): static
    {
        $this->errorTheme = $errorTheme;

        return $this;
    }

    public function getWrapperTheme(): Closure|array|null
    {
        return $this->wrapperTheme;
    }

    public function getInputTheme(): Closure|array|null
    {
        return $this->inputTheme;
    }

    public function getLabelTheme(): Closure|array|null
    {
        return $this->labelTheme;
    }

    public function getHelpTextTheme(): Closure|array|null
    {
        return $this->helpTextTheme;
    }

    public function getErrorTheme(): Closure|array|null
    {
        return $this->errorTheme;
    }
}
