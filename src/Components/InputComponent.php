<?php

namespace ChatAgency\InputComponentAction\Components;

use ChatAgency\InputComponentAction\Configs\ComponentConfig;

class InputComponent
{
    public function __construct(
        private ComponentConfig $config
    ) 
    {
        
    }
}
