<?php

namespace ChatAgency\InputComponentAction\Contracts;

use ChatAgency\BackendComponents\Contracts\BackendComponent;

interface ComponentComposer
{
    public function build(): BackendComponent;

    public function resolveCallback();
}