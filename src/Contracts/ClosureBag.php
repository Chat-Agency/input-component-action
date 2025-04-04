<?php

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface ClosureBag
{
    public function setWrapperClosure(Closure $wrapperClosure): static;

    public function setInputClosure(Closure $inputClosure): static;

    public function setLabelClosure(Closure $labelClosure): static;

    public function setErrorClosure(Closure $errorClosure): static;

    public function getWrapperClosure(): ?Closure;

    public function getInputClosure(): ?Closure;
    
    public function getLabelClosure(): ?Closure;

    public function getErrorClosure(): ?Closure;
}
