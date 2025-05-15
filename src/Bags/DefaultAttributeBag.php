<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Concerns\HasErrorAttributes;
use ChatAgency\InputComponentAction\Concerns\HasHelpTextAttributes;
use ChatAgency\InputComponentAction\Concerns\HasLabelAttributes;
use ChatAgency\InputComponentAction\Concerns\HasWrapperAttributes;
use ChatAgency\InputComponentAction\Concerns\IsAttributeBag;
use ChatAgency\InputComponentAction\Contracts\AttributeBag;
use ChatAgency\InputComponentAction\Contracts\ErrorAttributes;
use ChatAgency\InputComponentAction\Contracts\HelpTextAttributes;
use ChatAgency\InputComponentAction\Contracts\LabelAttributes;
use ChatAgency\InputComponentAction\Contracts\WrapperAttributes;

final class DefaultAttributeBag implements AttributeBag, ErrorAttributes, HelpTextAttributes, LabelAttributes, WrapperAttributes
{
    use HasErrorAttributes,
        HasHelpTextAttributes,
        HasLabelAttributes,
        HasWrapperAttributes,
        IsAttributeBag;
}
