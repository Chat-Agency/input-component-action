<?php

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Contracts\ClosureBag;
use ChatAgency\InputComponentAction\Concerns\IsClosureBag;

class DefaultClosureBag implements ClosureBag
{
    use IsClosureBag;
}
