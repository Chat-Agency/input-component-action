<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasErrorAttributes
{
    private Closure|array|null $errorAttributes = null;

    public function setErrorAttributes(Closure|array $errorAttributes): static
    {
        $this->errorAttributes = $errorAttributes;

        return $this;
    }

    public function getErrorAttributes(): Closure|array|null
    {
        return $this->errorAttributes;
    }
}
