<?php

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Concerns\isInputGroup;
use ChatAgency\BackendComponents\Contracts\BackendComponent;

final class DefaultInputGroup implements InputGroup
{
    use isInputGroup;

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

}
