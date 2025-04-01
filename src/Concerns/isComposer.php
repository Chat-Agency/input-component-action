<?php

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use Exception;

trait isComposer
{
    
    public function buildInputComponent(InputInterface|string $input, InputComponentRecipe $recipe): BackendComponent|ContentComponent
    {
        $attributes = $recipe->inputAttributes ?? [];
        $type = $recipe->inputType ?? ComponentEnum::TEXT_INPUT;
        
        $name = $attributes['name'] ?? $input->getName();
        $id = $attributes['id'] ?? $input->getName();
        $value = $attributes['value'] ?? $recipe->inputValue ?? $this->value;

        $component = ComponentBuilder::make($type);

        $component->setAttribute('name', $name)
            ->setAttributes($attributes)
            ->setAttribute('id', $id)
            ->setAttribute('value', $value)
            ->setAttribute('type', 'text');

        if($recipe->labelAsInputContent) {
            $component->setContent($input->getLabel());
        }

        $subComponents = $this->buildInputSubComponents($input);

        if($subComponents) {
            $component->setContents($subComponents);
        }

        return $component;
    }

    
    public function buildInputSubComponents(InputInterface $input): ?array
    {
        $subElements = $input->getSubElements();
        $components = [];

        if(!$subElements) {
            return null;
        }

        if (!$this->identifier) {
            throw new Exception('No action identifier provided');
        }
        
        foreach ($subElements as $element) {
            $elementRecipe = $element->getRecipe($this->identifier) ?? new InputComponentRecipe;
            $components[] = $this->buildInputComponent($element, $elementRecipe);
        }

        return $components;
    }
    
    public function resolveCallback() 
    {
        
    }
}
