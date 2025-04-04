<?php

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface AttributeBag
{
    public function setWrapperAttributes(Closure|array $wrapperAttributes): static;

    public function setInputAttributes(Closure|array $inputAttributes): static;

    public function setLabelAttributes(Closure|array $labelAttributes): static;

    public function setErrorAttributes(Closure|array $errorAttributes): static;
    
    public function getWrapperAttributes(): Closure|array;

    public function getInputAttributes(): Closure|array;
    
    public function getLabelAttributes(): Closure|array;

    public function getErrorAttributes(): Closure|array;
}
