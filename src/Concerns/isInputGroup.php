<?php

namespace ChatAgency\InputComponentAction\Concerns;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Composers\ErrorComposer;
use ChatAgency\InputComponentAction\Composers\InputComposer;
use ChatAgency\InputComponentAction\Composers\LabelComposer;
use ChatAgency\InputComponentAction\Composers\WrapperComposer;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

trait isInputGroup
{
    private InputInterface $input;
    private InputComponentRecipe $recipe;
    private ThemeManager $themeManager;
    private ?ThemeBag $defaultThemeBag = null;
    private ?string $value = null;
    private ?string $error = null;

    public function inject(
        InputInterface $input,
        InputComponentRecipe $recipe,
        ThemeManager $themeManager,
        ?ThemeBag $defaultThemeBag = null,
        ?string $value = null,
        ?string $error = null,
    ): static
    {
        $this->input = $input;
        $this->recipe = $recipe;
        $this->themeManager = $themeManager;
        $this->defaultThemeBag = $defaultThemeBag;
        $this->value = $value;
        $this->error = $error;

        return $this;
    }
    
    private function getWrapperComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        if($this->recipe->disableWrapper) {
            return null;
        }
        
        $composer = new WrapperComposer(
            input: $this->input,
            recipe: $this->recipe,
            themeManager:$this->themeManager,
            defaultWrapperTheme: $this?->defaultThemeBag->getWrapperTheme(),
        );

        return $composer->build();
    }

    private function getLabelComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        if($this->recipe->disableLabel) {
            return null;
        }
        
        $composer = new LabelComposer(
            input: $this->input,  
            recipe: $this->recipe,
            themeManager: $this->themeManager,
            defaultLabelTheme: $this?->defaultThemeBag->getLabelTheme(),
        );

        return $composer->build();
            
    }

    private function getInputComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        
        $composer = new InputComposer(
            input: $this->input, 
            recipe: $this->recipe,
            themeManager: $this->themeManager,
            value: $this->value,
            defaultInputTheme: $this?->defaultThemeBag->getInputTheme(),
        );

        return $composer->build();
    }

    
    private function getErrorComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        if($this->recipe->disableError) {
            return null;
        }
        
        $error = new ErrorComposer();

        return $error->build();
    }


}
