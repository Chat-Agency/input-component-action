<?php

namespace ChatAgency\InputComponentAction\Configs\Groups;

use ChatAgency\BackendComponents\Contracts\BackendComponent;

final class DefaultGroup
{
    private ?BackendComponent $label;
    private ?BackendComponent $input;
    private ?BackendComponent $error;

    /**
     * @return BackendComponent[]
     */
    public function getGroup() : array
    {
        return [
            $this->label,
            $this->input,
            $this->error,
        ];
    }

    public function setLabel($label): static
    {
        $this->label = $label;

        return $this;
    }

    public function setInput($input): static
    {
        $this->input = $input;

        return $this;
    }

    public function setError($error): static
    {
        $this->error = $error;

        return $this;
    }
}
