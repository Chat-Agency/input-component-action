<?php

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Concerns\IsThemeBag;

class DefaultThemeBag implements ThemeBag
{
    use IsThemeBag;
}
