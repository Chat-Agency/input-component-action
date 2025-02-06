<?php

namespace ChatAgency\InputComponentAction\Components;

use ChatAgency\InputComponentAction\Configs\ComponentConfig;

class WrapperComponent
{
    public function __construct(
        private ComponentConfig $config
    ) 
    {
        
    }
}
