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
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueManager;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

final class LabelComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?ThemeBag $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;

        $name = $input->getName();
        $label = $recipe->label ?? $input->getLabel();
        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $componentType = $this->resolveLabelType($recipe);

        $label = $this->resolveStringClosure($input, $label);

        $component = new MainBackendComponent($componentType, $themeManager);

        $inputType = $this->resolveInputType($recipe);

        $attributes = $recipe->attributeBag?->getLabelAttributes();
        $theme = $recipe->themeBag?->getLabelTheme() ?? $this->themeBag?->getLabelTheme();

        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $themes = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);

        if (! $recipe->emptyLabel) {
            $component->setContent($label);
        }

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
