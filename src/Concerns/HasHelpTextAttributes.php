<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasHelpTextAttributes
{
    private Closure|array|null $helpText = null;

    public function setHelpTextAttributes(Closure|array $helpText): static
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function getHelpTextAttributes(): Closure|array|null
    {
        return $this->helpText;
    }
}
