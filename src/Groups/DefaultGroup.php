<?php

namespace ChatAgency\InputComponentAction\Groups;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Composers\ErrorComposer;
use ChatAgency\InputComponentAction\Composers\InputComposer;
use ChatAgency\InputComponentAction\Composers\LabelComposer;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

final class DefaultGroup
{
    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private string $identifier,
        private ?string $value = null,
        private ?string $error = null
    ) 
    {
    }

    /**
     * @return BackendComponent[]
     */
    public function getGroup() : array
    {
        return [
            $this->getLabelComponent(),
            $this->getInputComponent(),
            $this->getErrorComponent(),
        ];
    }

    private function getLabelComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        
        $composer = new LabelComposer(
            input: $input, 
            recipe: $this->recipe,
        );

        return $composer->build();
            
    }

    private function getInputComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        
        $composer = new InputComposer(
            input: $input, 
            recipe: $this->recipe,
            identifier: $this->identifier,
            value: $this->value,
        );

        return $composer->build();
    }

    
    private function getErrorComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        $error = new ErrorComposer();

        return $error->build();
    }


}
