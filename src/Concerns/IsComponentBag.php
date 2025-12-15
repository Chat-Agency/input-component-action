<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\CompoundComponent;
use ChatAgency\BackendComponents\Contracts\StaticBuilder;
use Closure;

trait IsComponentBag
{
    private Closure|CompoundComponent|null $inputComponent = null;

    public function setInputComponent(Closure|CompoundComponent|StaticBuilder $inputComponent): static
    {
        $this->inputComponent = $inputComponent;

        return $this;
    }

    public function getInputComponent(): Closure|CompoundComponent|StaticBuilder|null
    {
        return $this->inputComponent;
    }
}
