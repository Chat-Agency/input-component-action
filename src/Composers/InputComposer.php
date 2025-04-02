<?php

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\InputComponentAction\Utilities\ThemeUtil;
use ChatAgency\InputComponentAction\InputComponentAction;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

class InputComposer implements ComponentComposer
{
    use isComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ?string $value = null,
        private array|Closure $defaultInputTheme = [],
    ) 
    {
    }

    public function build(): BackendComponent
    {
       return $this->buildInputComponent($this->input, $this->recipe);
    }

    public function buildInputComponent(InputInterface|string $input, InputComponentRecipe $recipe): BackendComponent|ContentComponent
    {
        $attributes = $recipe->inputAttributes ?? [];
        $type = $this->resolveInputType($recipe);
        
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

}
