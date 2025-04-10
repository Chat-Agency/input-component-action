<?php

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;

final class ErrorComposer implements ComponentComposer
{
    use IsComposer;

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $component = ComponentBuilder::make(ComponentEnum::PARAGRAPH);

        return $component;
    }

}
