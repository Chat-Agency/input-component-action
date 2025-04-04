<?php

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\InputComponentAction\Bags\DefaultClosureBag;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Bags\DefaultAttributeBag;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

final class LabelComposer implements ComponentComposer
{
    use isComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private array|Closure $defaultLabelTheme,
    ) 
    {
    }

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;

        $inputType = $this->resolveInputType($recipe);
        $componentType = $this->resolveLabelType($recipe);
        
        $attributeBag = $recipe->attributeBag ?? new DefaultAttributeBag;
        $callback = $recipe->closureBag ?? new DefaultClosureBag;
        
        $attributes = Support::resolveArrayClosure(value: $attributeBag->getInputAttributes(), input: $input, type: $inputType);
        $themes = Support::resolveArrayClosure(value: $recipe->inputTheme ?? $this->defaultLabelTheme, input: $input, type:$inputType);
        $label = $recipe->label ?? $input->getLabel();

        $component = new MainBackendComponent($componentType, $this->themeManager);

        $component->setContent($label)
            ->setAttribute('for', $input->getName())
            ->setAttributes($attributes);

        if($themes) {
            $component->setThemes($themes);
        }

        $component = $this->resolveComponentClosure(
            component: $component, 
            closure: $callback->getLabelClosure(), 
            input: $input, 
            type: $inputType
        );

        return $component;
    }
}
