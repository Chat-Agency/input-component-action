<?php

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Contracts\ClosureBag;
use ChatAgency\InputComponentAction\Concerns\isClosureBag;

class DefaultClosureBag implements ClosureBag
{
    use isClosureBag;
}
