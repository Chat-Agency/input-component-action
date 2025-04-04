<?php

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\InputComponentAction\InputComponentAction;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\InputComponentAction\Bags\DefaultClosureBag;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Bags\DefaultAttributeBag;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

final class InputComposer implements ComponentComposer
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

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
       return $this->buildInputComponent($this->input, $this->recipe);
    }

    public function buildInputComponent(InputInterface|string $input, InputComponentRecipe $recipe): BackendComponent|ContentComponent
    {
        $type = $this->resolveInputType($recipe);

        $theme = $recipe->inputTheme ?? $this->defaultInputTheme;
        $attributeBag = $recipe->attributeBag ?? new DefaultAttributeBag;
        $callback = $recipe->closureBag ?? new DefaultClosureBag;
        
        $attributes = Support::resolveArrayClosure(value: $attributeBag->getInputAttributes(), input: $input, type: $type);
        $themes = Support::resolveArrayClosure($theme, input: $input, type: $type);
        
        $component = new MainBackendComponent($type, $this->themeManager);

        $component->setAttribute('name', $input->getName())
            ->setAttribute('id', $input->getName())
            ->setAttribute('type', $type->value)
            ->setAttribute('value', $this->value)
            ->setAttributes($attributes);

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

        $component = $this->resolveComponentClosure(
            component: $component, 
            closure: $callback->getLabelClosure(), 
            input: $input, 
            type: $type
        );

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
