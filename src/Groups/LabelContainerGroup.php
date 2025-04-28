<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Concerns\IsInputGroup;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Utilities\Support;
use Exception;

class LabelContainerGroup implements InputGroup
{
    use IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();
        $label = $this->getLabelComponent();
        $input = $this->getInputComponent();
        $error = $this->getErrorComponent();

        if (! $label) {
            throw new Exception('The label is mandatory to use this group', 500);
        }

        $components = [];

        $components['label'] = $label->setContent(content: $input, key: 'input');

        if ($error) {
            $components['error'] = $error;
        }

        return $wrapper->setContents($components);

    }
}
