<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use Chatagency\CrudAssistant\DataContainer;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\InputComponentAction\Bags\DefaultErrorBag;
use ChatAgency\InputComponentAction\Bags\DefaultValueBag;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;

final class ErrorComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private ?DefaultValueBag $values = null,
        private ?DefaultErrorBag $errors = null,
        private array|Closure|null $defaultErrorTheme = [],
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = Support::getRecipe($input);
        $errorResolver = $this->errors;

        $componentType = $this->resolveErrorType($recipe);
        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $component = new MainBackendComponent($componentType, $themeManager);

        $theme = $recipe->themeBag?->getErrorTheme() ?? $this->defaultErrorTheme;
        $themes = Support::resolveArrayClosure(value: $theme ?? $this->defaultErrorTheme, input: $input, type: $componentType);

        $error = $errorResolver->resolve($input);
        if($error) {
            $component->setContent($error);
        }

        if ($themes) {
            $component->setThemes($themes);
        }

        new DataContainer;

        return $component;
    }
}
