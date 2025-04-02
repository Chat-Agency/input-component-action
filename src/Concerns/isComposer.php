<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Closure;
use BackedEnum;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\ThemeUtil;
use ChatAgency\InputComponentAction\InputComponentAction;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

trait isComposer
{
    
    public function buildInputComponent(InputInterface|string $input, InputComponentRecipe $recipe): BackendComponent|ContentComponent
    {
        $attributes = $recipe->inputAttributes ?? [];
        $type = $recipe->inputType ?? ComponentEnum::TEXT_INPUT;
        
        $name = $attributes['name'] ?? $input->getName();
        $id = $attributes['id'] ?? $input->getName();
        $value = $attributes['value'] ?? $recipe->inputValue ?? $this->value;
        $themes = ThemeUtil::resolveTheme($recipe->inputTheme ?? $this->defaultInputTheme, $type);

        $component = new MainBackendComponent($type, $this->themeManager);

        $component->setAttribute('name', $name)
            ->setAttributes($attributes)
            ->setAttribute('id', $id)
            ->setAttribute('value', $value)
            ->setAttribute('type', 'text');

        if($recipe->labelAsInputContent) {
            $component->setContent($input->getLabel());
        }

        if($themes) {
            $component->setThemes($themes);
        }

        $subComponents = $this->buildInputSubComponents($input);

        if($subComponents) {
            $component->setContents($subComponents);
        }

        $this->resolveCallback($component, $recipe, $value);

        return $component;
    }

    
    public function buildInputSubComponents(InputInterface $input): ?array
    {
        $subElements = $input->getSubElements();
        $components = [];

        if(!$subElements) {
            return null;
        }
        
        foreach ($subElements as $element) {
            $elementRecipe = $element->getRecipe(InputComponentAction::getIdentifier()) ?? new InputComponentRecipe;
            $components[] = $this->buildInputComponent($element, $elementRecipe);
        }

        return $components;
    }
    
    public function resolveCallback(BackendComponent $component, InputComponentRecipe $recipe, ?string $value = null): BackendComponent
    {
        

        return $component;
    }

}
