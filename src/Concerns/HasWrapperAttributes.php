<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasWrapperAttributes
{
    private Closure|array|null $wrapperAttributes = null;

    public function setWrapperAttributes(Closure|array $wrapperAttributes): static
    {
        $this->wrapperAttributes = $wrapperAttributes;

        return $this;
    }

    public function getWrapperAttributes(): Closure|array|null
    {
        return $this->wrapperAttributes;
    }

}
