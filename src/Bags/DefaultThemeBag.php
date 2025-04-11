<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Concerns\IsThemeBag;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;

class DefaultThemeBag implements ThemeBag
{
    use IsThemeBag;
}
