<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;

trait HasLabelTheme
{
    private Closure|array|null $labelTheme = null;

    public function setLabelTheme(Closure|array $labelTheme): static
    {
        $this->labelTheme = $labelTheme;

        return $this;
    }

    public function getLabelTheme(): Closure|array|null
    {
        return $this->labelTheme;
    }
}
