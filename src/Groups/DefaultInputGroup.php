<?php

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Concerns\IsInputGroup;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;

final class DefaultInputGroup implements InputGroup
{
    use IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
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
