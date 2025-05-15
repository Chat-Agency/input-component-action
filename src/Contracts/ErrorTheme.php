<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface ErrorTheme
{
    public function setErrorTheme(Closure|array $errorTheme): static;

    public function getErrorTheme(): Closure|array|null;
}
