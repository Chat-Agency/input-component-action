<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface AttributeBag
{
    public function setInputAttributes(Closure|array $inputAttributes): static;

    public function getInputAttributes(): Closure|array|null;
}
