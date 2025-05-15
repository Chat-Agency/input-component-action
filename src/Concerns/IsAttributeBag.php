<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait IsAttributeBag
{
    private Closure|array|null $inputAttributes = null;

    public function setInputAttributes(Closure|array $inputAttributes): static
    {
        $this->inputAttributes = $inputAttributes;

        return $this;
    }

    public function getInputAttributes(): Closure|array|null
    {
        return $this->inputAttributes;
    }
}
