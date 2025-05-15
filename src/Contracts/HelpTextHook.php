<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface HelpTextHook
{
    public function setHelpTextHook(Closure $helpTextHook): static;

    public function getHelpTextHook(): ?Closure;
}
