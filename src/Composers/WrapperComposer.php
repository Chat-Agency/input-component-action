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
use ChatAgency\InputComponentAction\Contracts\ErrorBag;
use ChatAgency\InputComponentAction\Contracts\ValueBag;
use ChatAgency\InputComponentAction\Utilities\Support;
use Closure;

class WrapperComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private ?ValueBag $values = null,
        private ?ErrorBag $errors = null,
        private array|Closure|null $defaultWrapperTheme = [],
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = Support::getRecipe($input);
        $componentType = $this->resolveWrapperType($recipe);
        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $component = new MainBackendComponent($componentType, $themeManager);

        $inputType = $this->resolveInputType($recipe);

        $attributes = $recipe->attributeBag?->getInputAttributes() ?? null;
        $theme = $recipe->themeBag?->getWrapperTheme() ?? $this->defaultWrapperTheme;
        $callback = $recipe?->hookBag ?? new DefaultHookBag;

        $attributes = Support::resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $theme = Support::resolveArrayClosure($theme, input: $input, type: $inputType);

        if ($theme) {
            $component->setThemes($theme);
        }

        if ($recipe->labelAsInputContent) {
            $component->setContent($input->getLabel());
        }

        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback->getWrapperHook(),
            input: $input,
            type: $inputType
        );

        return $component;
    }
}
