<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface LabelTheme
{
    public function setLabelTheme(Closure|array $labelTheme): static;

    public function getLabelTheme(): Closure|array|null;
}
