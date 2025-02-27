<?php

namespace ChatAgency\InputComponentAction\Configs;

readonly class ComponentConfig
{
    public function __construct(
        public array $content = [],
        public array $attributes = [],
        public array $theme = [],
    ) 
    {
    }
}
