<?php

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Concerns\isInputGroup;
use ChatAgency\BackendComponents\Contracts\BackendComponent;

final class InputLabelErrorGroup implements InputGroup
{
    use isInputGroup;

    /**
     * @return BackendComponent[]
     */
    public function getGroup(): BackendComponent
    {
        $components =  [];
        $recipe = $this->recipe;

        $components[] = $this->getInputComponent();

        if(!$recipe->disableLabel) {
            $components[] = $this->getLabelComponent();
        }
        
        if(!$recipe->disableError) {
            $components[] = $this->getErrorComponent();
        }

        $wrapper = $this->getErrorComponent();

        return $wrapper->setContents($components);
    }

}
