<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Concerns\IsHookBag;
use ChatAgency\InputComponentAction\Contracts\HookBag;

final class DefaultHookBag implements HookBag
{
    use IsHookBag;
}
