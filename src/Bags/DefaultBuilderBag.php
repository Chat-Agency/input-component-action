<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Concerns\HasErrorBuilder;
use ChatAgency\InputComponentAction\Concerns\HasHelpTextBuilder;
use ChatAgency\InputComponentAction\Concerns\HasLabelBuilder;
use ChatAgency\InputComponentAction\Concerns\HasWrapperBuilder;
use ChatAgency\InputComponentAction\Concerns\IsBuilderBag;
use ChatAgency\InputComponentAction\Contracts\BuilderBag;
use ChatAgency\InputComponentAction\Contracts\ErrorBuilder;
use ChatAgency\InputComponentAction\Contracts\HelpTextBuilder;
use ChatAgency\InputComponentAction\Contracts\LabelBuilder;
use ChatAgency\InputComponentAction\Contracts\WrapperBuilder;

class DefaultBuilderBag implements BuilderBag, ErrorBuilder, HelpTextBuilder, LabelBuilder, WrapperBuilder
{
    use HasErrorBuilder,
        HasHelpTextBuilder,
        HasLabelBuilder,
        HasWrapperBuilder,
        IsBuilderBag;
}
