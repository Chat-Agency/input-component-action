<?php

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

class LabelComposer implements ComponentComposer
{
    use isComposer;
    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
    ) 
    {
    }

    public function build() : BackendComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;
        $attributes = $recipe->inputAttributes ?? [];

        $component = new MainBackendComponent(ComponentEnum::LABEL, $this->themeManager);

        $label = $recipe->label ?? $input->getLabel();
        $for = $attributes['for'] ?? $input->getName();
        
        $component->setContent($label)
            ->setAttribute('for', $for);

        return $component;
    }
}
