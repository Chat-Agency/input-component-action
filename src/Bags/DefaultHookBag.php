<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Concerns\HasErrorHook;
use ChatAgency\InputComponentAction\Concerns\HasHelpTextHook;
use ChatAgency\InputComponentAction\Concerns\HasLabelHook;
use ChatAgency\InputComponentAction\Concerns\HasWrapperHook;
use ChatAgency\InputComponentAction\Concerns\IsHookBag;
use ChatAgency\InputComponentAction\Contracts\ErrorHook;
use ChatAgency\InputComponentAction\Contracts\HelpTextHook;
use ChatAgency\InputComponentAction\Contracts\HookBag;
use ChatAgency\InputComponentAction\Contracts\LabelHook;
use ChatAgency\InputComponentAction\Contracts\WrapperHook;

final class DefaultHookBag implements ErrorHook, HelpTextHook, HookBag, LabelHook, WrapperHook
{
    use HasErrorHook,
        HasHelpTextHook,
        HasLabelHook,
        HasWrapperHook,
        IsHookBag;
}
