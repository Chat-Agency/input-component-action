<?php

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
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
        private string $identifier,
        private ?string $value = null,
    ) 
    {
    }

    public function build(): BackendComponent
    {
       return $this->buildInputComponent($this->input, $this->recipe);
    }


}
