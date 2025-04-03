<?php

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface ThemeBag
{
    public function setWrapperTheme(Closure|array $wrapperTheme): static;

    public function setInputTheme(Closure|array $inputTheme): static;

    public function setLabelTheme(Closure|array $labelTheme): static;

    public function setErrorTheme(Closure|array $errorTheme): static;

    public function getWrapperTheme(): Closure|array;

    public function getInputTheme(): Closure|array;
    
    public function getLabelTheme(): Closure|array;

    public function getErrorTheme(): Closure|array;
}
