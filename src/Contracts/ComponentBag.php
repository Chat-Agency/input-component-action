<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\CompoundComponent;
use ChatAgency\BackendComponents\Contracts\StaticBuilder;
use Closure;

interface ComponentBag
{
    public function setInputComponent(Closure|CompoundComponent|StaticBuilder $inputComponent): static;

    public function getInputComponent(): Closure|CompoundComponent|StaticBuilder|null;
}
