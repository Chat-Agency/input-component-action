<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Concerns\IsAttributeBag;
use ChatAgency\InputComponentAction\Contracts\AttributeBag;

final class DefaultAttributeBag implements AttributeBag
{
    use IsAttributeBag;
}
