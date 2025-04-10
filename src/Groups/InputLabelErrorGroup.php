<?php

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Concerns\IsInputGroup;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Utilities\Support;

final class InputLabelErrorGroup implements InputGroup
{
    use IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();
        $label = $this->getLabelComponent();
        $input = $this->getInputComponent();
        $error = $this->getErrorComponent();

        $components = [];

        $components[] = $input;

        if($label) {
            $components[] = $label;
        }
        
        if($error ) {
            $components[] = $error ;
        }

        return $wrapper->setContents($components);
    }

}
