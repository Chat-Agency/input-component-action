<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait IsThemeBag
{
    private Closure|array|null $inputTheme = null;

    public function setInputTheme(Closure|array $inputTheme): static
    {
        $this->inputTheme = $inputTheme;

        return $this;
    }

    public function getInputTheme(): Closure|array|null
    {
        return $this->inputTheme;
    }
}
