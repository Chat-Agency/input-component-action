<?php

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
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


}
