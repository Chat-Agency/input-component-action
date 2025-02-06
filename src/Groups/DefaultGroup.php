<?php

namespace ChatAgency\InputComponentAction\Configs\Groups;

use ChatAgency\InputComponentAction\Components\InputComponent;
use ChatAgency\InputComponentAction\Configs\ComponentConfig;

class DefaultGroup
{
    /**
     * @param ComponentConfig[] $configs
     */
    public function __construct(private array $configs) 
    {
        
    }

    public function processGroup()
    {
       
    }

    public function getGroup(): array
    {
        return [
            InputComponent::class => new InputComponent($this->getConfig(InputComponent::class)),
        ];
    }

    public function getConfig(string $configType) : ComponentConfig
    {
        return $this->configs[$configType] ?? new ComponentConfig();
    }
}
