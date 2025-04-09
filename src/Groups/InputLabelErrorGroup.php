<?php

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Concerns\isInputGroup;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Utilities\Support;

final class InputLabelErrorGroup implements InputGroup
{
    use isInputGroup;

    /**
     * @return BackendComponent[]
     */
    public function getGroup(): BackendComponent
    {
        $components =  [];
        $recipe = Support::getRecipe($this->input);

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
