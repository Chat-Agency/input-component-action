<?php

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Concerns\isThemeBag;

class DefaultThemeBag implements ThemeBag
{
    use isThemeBag;
}
