<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasErrorTheme
{
    private Closure|array|null $errorTheme = null;

    public function setErrorTheme(Closure|array $errorTheme): static
    {
        $this->errorTheme = $errorTheme;

        return $this;
    }

    public function getErrorTheme(): Closure|array|null
    {
        return $this->errorTheme;
    }
}
