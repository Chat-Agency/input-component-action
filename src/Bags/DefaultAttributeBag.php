<?php

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\AttributeBag;
use ChatAgency\InputComponentAction\Concerns\isAttributeBag;

class DefaultAttributeBag implements AttributeBag
{
    use isAttributeBag;
}
