<?php

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\InputComponentAction\Bags\DefaultThemeBag;
use ChatAgency\InputComponentAction\InputComponentAction;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\InputComponentAction\Bags\DefaultClosureBag;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Bags\DefaultAttributeBag;
use ChatAgency\InputComponentAction\Groups\DefaultInputGroup;
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
        private array|Closure|null $defaultInputTheme = [],
    ) 
    {
    }

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
       return $this->buildInputComponent($this->input, $this->recipe);
    }

    public function buildInputComponent(InputInterface|string $input, InputComponentRecipe $recipe): BackendComponent|ContentComponent
    {
        $inputType = $this->resolveInputType($recipe);

        $attributes = $recipe->attributeBag?->getInputAttributes() ?? null;
        $theme = $recipe->themeBag?->getInputTheme() ?? $this->defaultInputTheme;
        $callback = $recipe->closureBag ?? new DefaultClosureBag;
        $value = $this->resolveInputValue($recipe, $this->value);
        
        $attributes = Support::resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $theme = Support::resolveArrayClosure($theme, input: $input, type: $inputType);
        
        $component = new MainBackendComponent($inputType, $this->themeManager);

        $component->setAttribute('name', $input->getName())
            ->setAttribute('id', $input->getName())
            ->setAttribute('value', $value);

        if($attributes) {
            $component->setAttributes($attributes);
        }

        if($theme) {
            $component->setThemes($theme);
        }

        if($recipe->labelAsInputContent) {
            $component->setContent($input->getLabel());
        }

        $subComponents = $this->buildInputSubComponents();

        if($subComponents) {
            $component->setContents($subComponents);
        }

        $component = $this->resolveComponentClosure(
            component: $component, 
            closure: $callback->getLabelClosure(), 
            input: $input, 
            type: $inputType
        );

        return $component;
    }

    
    public function buildInputSubComponents(): ?array
    {
        $input = $this->input;

        $subElements = $input->getSubElements();
        $components = [];

        if(!$subElements) {
            return null;
        }
        
        foreach ($subElements as $element) {
            $components[] = $this->resolveGroup($element);
        }

        return $components;
    }

    public function resolveGroup(InputInterface $input): BackendComponent
    {
        $recipe = $input->getRecipe(InputComponentAction::getIdentifier());
        
        $group = $recipe->inputGroup ?? $this->defaultInputGroup ?? new DefaultInputGroup;
        
        $group = $group->inject(
            input: $input, 
            recipe: $recipe,
            themeManager: $this->themeManager,
            defaultThemeBag: new DefaultThemeBag,
        );

        return $group->getGroup();

    }   

}
