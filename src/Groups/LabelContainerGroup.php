<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Concerns\HasError;
use ChatAgency\InputComponentAction\Concerns\HasLabel;
use ChatAgency\InputComponentAction\Concerns\HasWrapper;
use ChatAgency\InputComponentAction\Concerns\IsInputGroup;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Utilities\Support;
use Exception;

class LabelContainerGroup implements InputGroup
{
    use HasError,
        HasLabel,
        HasWrapper,
        IsInputGroup;

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

        $label->setContent(content: $input, key: 'input');

        $components['label'] = $label;

        if ($error) {
            $components['error'] = $error;
        }

        return $wrapper->setContents($components);

    }
}
