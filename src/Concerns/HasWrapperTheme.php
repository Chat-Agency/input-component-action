<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasWrapperTheme
{
    private Closure|array|null $wrapperTheme = null;

    public function setWrapperTheme(Closure|array $wrapperTheme): static
    {
        $this->wrapperTheme = $wrapperTheme;

        return $this;
    }

    public function getWrapperTheme(): Closure|array|null
    {
        return $this->wrapperTheme;
    }
}
