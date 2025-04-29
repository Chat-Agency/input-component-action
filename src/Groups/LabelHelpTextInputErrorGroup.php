<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Groups;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Concerns\HasError;
use ChatAgency\InputComponentAction\Concerns\HasHelpText;
use ChatAgency\InputComponentAction\Concerns\HasLabel;
use ChatAgency\InputComponentAction\Concerns\HasWrapper;
use ChatAgency\InputComponentAction\Concerns\IsInputGroup;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Utilities\Support;

final class LabelHelpTextInputErrorGroup implements InputGroup
{
    use HasError,
        HasHelpText,
        HasLabel,
        HasWrapper,
        IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();
        $label = $this->getLabelComponent();
        $helpText = $this->getHelpTextComponent();
        $input = $this->getInputComponent();
        $error = $this->getErrorComponent();

        $components = [];

        if ($label) {
            $components['label'] = $label;
        }

        if ($helpText) {
            $components['helpText'] = $helpText;
        }

        $components['input'] = $input;

        if ($error) {
            $components['error'] = $error;
        }

        return $wrapper->setContents($components);
    }
}
