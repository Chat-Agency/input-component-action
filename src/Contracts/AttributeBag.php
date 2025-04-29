<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface AttributeBag
{
    public function setWrapperAttributes(Closure|array $wrapperAttributes): static;

    public function setInputAttributes(Closure|array $inputAttributes): static;

    public function setLabelAttributes(Closure|array $labelAttributes): static;

    public function setErrorAttributes(Closure|array $errorAttributes): static;

    public function setHelpTextAttributes(Closure|array $errorAttributes): static;

    public function getWrapperAttributes(): Closure|array|null;

    public function getInputAttributes(): Closure|array|null;

    public function getLabelAttributes(): Closure|array|null;

    public function getErrorAttributes(): Closure|array|null;

    public function getHelpTextAttributes(): Closure|array|null;
}
