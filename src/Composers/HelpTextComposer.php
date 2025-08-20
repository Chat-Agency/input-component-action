<?php

declare(strict_types=1);

namespace Composers;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Bags\DefaultHookBag;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\InputComponentAction\Contracts\ErrorManager;
use ChatAgency\InputComponentAction\Contracts\HelpTextBuilder;
use ChatAgency\InputComponentAction\Contracts\HelpTextTheme;
use ChatAgency\InputComponentAction\Contracts\ValueManager;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

class HelpTextComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private HelpTextBuilder $defaultBuilderBag,
        private ThemeManager $themeManager,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?HelpTextTheme $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;

        $recipe = $this->recipe;

        $helpText = $recipe->helpText;
        $componentType = $recipe->helpTextType ?? ComponentEnum::DIV;
        $inputType = $this->resolveInputType($recipe);
        $callback = $recipe->hookBag?->getInputHook() ?? null;

        $attributes = $recipe->attributeBag?->getHelpTextAttributes() ?? null;
        $theme = $recipe->themeBag?->getHelpTextTheme() ?? $this->themeBag?->getHelpTextTheme();

        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $themes = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);
        $helpText = $this->resolveStringClosure(input: $input, stringClosure: $helpText);

        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $builder = $this->defaultBuilderBag->getHelpTextBuilder();

        $component = $builder
            ? $builder::make($componentType)
            : new MainBackendComponent($componentType, $themeManager);

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
            type: $inputType,
            values: $this->values,
            errors: $this->errors,
        );

        return $component;
    }
}
