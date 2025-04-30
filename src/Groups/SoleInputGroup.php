<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Concerns\HasWrapper;
use ChatAgency\InputComponentAction\Concerns\IsInputGroup;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Utilities\Support;

class SoleInputGroup implements InputGroup
{
    use HasWrapper,
        IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();

        $input = $this->getInputComponent();

        return $wrapper->setContent($input);
    }
}
