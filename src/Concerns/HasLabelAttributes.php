<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasLabelAttributes
{
    private Closure|array|null $labelAttributes = null;

    public function setLabelAttributes(Closure|array $labelAttributes): static
    {
        $this->labelAttributes = $labelAttributes;

        return $this;
    }

    public function getLabelAttributes(): Closure|array|null
    {
        return $this->labelAttributes;
    }
}
