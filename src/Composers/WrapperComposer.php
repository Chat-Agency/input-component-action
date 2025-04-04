<?php

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use Closure;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

class WrapperComposer implements ComponentComposer
{
    use isComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private array|Closure $defaultWrapperTheme,
    ) 
    {
    }

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;

        $inputType = $this->resolveInputType($recipe);
        $componentType = $this->resolveWrapperType($recipe);

        $theme = Support::resolveArrayClosure(value: $recipe->inputTheme ?? $this->defaultWrapperTheme, input: $input, type: $inputType);

        // $type = $recipe->wrapp

        $component = new MainBackendComponent($componentType, $this->themeManager);
        
        $component->setThemes($theme);

        return $component;
    }
}
