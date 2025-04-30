<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;

interface HookBag
{
    public function setWrapperHook(Closure $wrapperHook): static;

    public function setInputHook(Closure $inputHook): static;

    public function setLabelHook(Closure $labelHook): static;

    public function setErrorHook(Closure $errorHook): static;

    public function setHelpTextHook(Closure $helpTextHook): static;

    public function getWrapperHook(): ?Closure;

    public function getInputHook(): ?Closure;

    public function getLabelHook(): ?Closure;

    public function getErrorHook(): ?Closure;

    public function getHelpTextHook(): ?Closure;
}
