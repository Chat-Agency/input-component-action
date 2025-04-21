<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Composers;

use Closure;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Bags\DefaultHookBag;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\InputComponentAction\Bags\DefaultErrorBag;
use ChatAgency\InputComponentAction\Bags\DefaultValueBag;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;

final class LabelComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private ?DefaultValueBag $values = null,
        private ?DefaultErrorBag $errors = null,
        private array|Closure|null $defaultLabelTheme = [],
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $name = Support::getName($input);
        $recipe = Support::getRecipe($input);
        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $componentType = $this->resolveLabelType($recipe);
        $label = $this->resolveLabel($input);

        $component = new MainBackendComponent($componentType, $themeManager);

        $inputType = $this->resolveInputType($recipe);

        $attributes = $recipe->attributeBag?->getLabelAttributes();
        $theme = $recipe->themeBag?->getLabelTheme() ?? $this->defaultLabelTheme;

        $attributes = Support::resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $themes = Support::resolveArrayClosure(value: $theme ?? $this->defaultLabelTheme, input: $input, type: $inputType);

        $component->setContent($label);

        if (! $recipe->disableDefaultForAttribute) {
            $component->setAttribute('for', $name);
        }

        if ($attributes) {
            $component->setAttributes($attributes);
        }

        if ($themes) {
            $component->setThemes($themes);
        }

        $callback = $recipe->hookBag ?? new DefaultHookBag;
        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback->getLabelHook(),
            input: $input,
            type: $inputType
        );

        return $component;
    }
}
