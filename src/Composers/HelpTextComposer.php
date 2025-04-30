<?php

declare(strict_types=1);

namespace Composers;

use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\InputComponentAction\Contracts\ErrorBag;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueBag;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Bags\DefaultHookBag;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

class HelpTextComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ?ValueBag $values = null,
        private ?ErrorBag $errors = null,
        private ?ThemeBag $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;

        $recipe = Support::getRecipe($input);

        $helpText = $recipe->helpText;
        $type = $recipe->helpTextType ?? ComponentEnum::DIV;
        $inputType = $this->resolveInputType($recipe);
        $callback = $recipe->hookBag?->getInputHook() ?? null;

        $attributes = $recipe->attributeBag?->getHelpTextAttributes() ?? null;
        $theme = $recipe->themeBag?->getLabelTheme() ?? $this->themeBag?->getLabelTheme();

        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $themes = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);
        $helpText = $this->resolveStringClosure(input: $input, stringClosure: $helpText);

        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $component = new MainBackendComponent($type, $themeManager);

        if ($attributes) {
            $component->setAttributes($attributes);
        }

        if ($themes) {
            $component->setThemes($themes);
        }

        if ($helpText) {
            $component->setContent($helpText);
        }

        $callback = $recipe->hookBag ?? new DefaultHookBag;
        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback->getHelpTextHook(),
            input: $input,
            type: $inputType
        );

        return $component;
    }
}
