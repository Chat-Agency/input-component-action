<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Bags\DefaultHookBag;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use ChatAgency\InputComponentAction\Contracts\ErrorManager;
use ChatAgency\InputComponentAction\Contracts\ErrorTheme;
use ChatAgency\InputComponentAction\Contracts\ValueManager;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

final class ErrorComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?ErrorTheme $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;
        $errorResolver = $this->errors;
        $callback = $recipe?->hookBag ?? new DefaultHookBag;

        $componentType = $this->resolveErrorType($recipe);
        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $component = new MainBackendComponent($componentType, $themeManager);

        $inputType = $this->resolveInputType($recipe);

        $theme = $recipe->themeBag?->getErrorTheme() ?? $this->themeBag?->getErrorTheme();
        $themes = $this->resolveArrayClosure(value: $theme, input: $input, type: $componentType);

        $error = $errorResolver->resolve($input, $recipe);
        if ($error) {
            $component->setContent($error);
        }

        if ($themes) {
            $component->setThemes($themes);
        }

        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback->getErrorHook(),
            input: $input,
            type: $inputType,
            values: $this->values,
            errors: $this->errors,
        );

        return $component;
    }
}
