<?php

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Concerns\isInputGroup;
use ChatAgency\BackendComponents\Contracts\BackendComponent;

final class DefaultInputGroup implements InputGroup
{
    use isInputGroup;

    public function getGroup() : BackendComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();
        $label = $this->getLabelComponent();
        $input = $this->getInputComponent();
        $error = $this->getErrorComponent();

        $components = [];

        if($label) {
            $components[] = $label;
        }
        
        $components[] = $input;
        
        if($error ) {
            $components[] = $error ;
        }

        return $wrapper->setContents($components);

    }

}
