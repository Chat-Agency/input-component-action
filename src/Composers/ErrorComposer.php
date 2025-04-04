<?php

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\InputComponentAction\Concerns\isComposer;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;

final class ErrorComposer implements ComponentComposer
{
    use isComposer;

    public function build(): BackendComponent
    {
        $component = ComponentBuilder::make(ComponentEnum::PARAGRAPH);

        return $component;
    }

}
