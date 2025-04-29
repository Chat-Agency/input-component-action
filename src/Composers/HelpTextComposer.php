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
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\InputComponentAction\Contracts\ErrorBag;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueBag;
use ChatAgency\InputComponentAction\Utilities\Support;

class HelpTextComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
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
        $attributes = $recipe->attributeBag?->getHelpTextAttributes() ?? null;
        $inputType = $this->resolveInputType($recipe);

        $attributes = Support::resolveArrayClosure(value: $attributes, input: $input, type: $inputType);

        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $component = new MainBackendComponent($type, $themeManager);

        if (Support::isClosure($helpText)) {
            $component = $helpText($component);
        } else {
            $component->setContent($helpText);
        }

        /**
         * Set/overwrite attributes
         */
        if ($attributes) {
            $component->setAttributes($attributes);
        }

        return $component;
    }
}
