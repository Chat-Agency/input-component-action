<?php

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\InputComponentAction\Bags\DefaultClosureBag;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;

final class LabelComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private array|Closure|null $defaultLabelTheme = [],
        private ?string $value = null,
        private ?string $error = null,
    ) 
    {
    }

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = Support::getRecipe($input);

        $inputType = $this->resolveInputType($recipe);
        $componentType = $this->resolveLabelType($recipe);
        
        $attributes = $recipe->attributeBag?->getLabelAttributes() ?? null;
        $callback = $recipe->closureBag ?? new DefaultClosureBag;
        $theme = $recipe->themeBag?->getLabelTheme() ?? $this->defaultLabelTheme;
        
        $attributes = Support::resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $themes = Support::resolveArrayClosure(value: $theme ?? $this->defaultLabelTheme, input: $input, type:$inputType);
        $label = $recipe->label ?? $input->getLabel();

        $component = new MainBackendComponent($componentType, $this->themeManager);

        $component->setContent($label)
            ->setAttribute('for', $input->getName());

        if($attributes) {
            $component->setAttributes($attributes);
        }
    
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
