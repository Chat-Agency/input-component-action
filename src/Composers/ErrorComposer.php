<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\DataContainer;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use ChatAgency\InputComponentAction\Utilities\Support;
use Closure;

final class ErrorComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private array|Closure|null $defaultErrorTheme = [],
        private ?string $value = null,
        private ?string $error = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = Support::getRecipe($input);

        $componentType = $this->resolveErrorType($recipe);
        $theme = $recipe->themeBag?->getLabelTheme() ?? $this->defaultErrorTheme;
        $themes = Support::resolveArrayClosure(value: $theme ?? $this->defaultErrorTheme, input: $input, type: $componentType);

        $component = new MainBackendComponent($componentType, $this->themeManager);

        if ($themes) {
            $component->setThemes($themes);
        }

        new DataContainer;

        return $component;
    }
}
