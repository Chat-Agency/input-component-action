<?php

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Composers\ErrorComposer;
use ChatAgency\InputComponentAction\Composers\InputComposer;
use ChatAgency\InputComponentAction\Composers\LabelComposer;

trait isInputGroup
{
    private function getLabelComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        $composer = new LabelComposer(
            input: $this->input,  
            recipe: $this->recipe,
            themeManager: $this->themeManager,
            defaultLabelTheme: $this->themeBag->getLabelTheme(),
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
            defaultInputTheme: $this->themeBag->getInputTheme(),
        );

        return $composer->build();
    }

    
    private function getErrorComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        $error = new ErrorComposer();

        return $error->build();
    }

}
