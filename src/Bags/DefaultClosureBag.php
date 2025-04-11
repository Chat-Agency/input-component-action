<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Concerns\IsClosureBag;
use ChatAgency\InputComponentAction\Contracts\ClosureBag;

class DefaultClosureBag implements ClosureBag
{
    use IsClosureBag;
}
