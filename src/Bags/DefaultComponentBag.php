<?php

declare(strict_types=1);

namespace Bags;

use ChatAgency\InputComponentAction\Concerns\IsComponentBag;
use ChatAgency\InputComponentAction\Contracts\ComponentBag;

class DefaultComponentBag implements ComponentBag
{
    use IsComponentBag;
}
