<?php

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
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
    ) 
    {
    }

    public function build() : BackendComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;

        $component = ComponentBuilder::make(ComponentEnum::LABEL);

        $label = $recipe->label ?? $input->getLabel();
        $for = $input->getName();

        $component->setContent($label)
            ->setAttribute('for', $for);

        return $component;
    }
}
