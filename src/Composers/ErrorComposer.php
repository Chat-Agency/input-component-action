<?php

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;

final class ErrorComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private array|Closure|null $defaultInputTheme = [],
        private ?string $value = null,
        private ?string $error = null,
    ) 
    {
    }

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $component = ComponentBuilder::make(ComponentEnum::PARAGRAPH);

        return $component;
    }

}
