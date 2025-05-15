<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasHelpTextTheme
{
    private Closure|array|null $helpTextTheme = null;

    public function setHelpTextTheme(Closure|array $helpTextTheme): static
    {
        $this->helpTextTheme = $helpTextTheme;

        return $this;
    }

    public function getHelpTextTheme(): Closure|array|null
    {
        return $this->helpTextTheme;
    }
}
