<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Composers;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\MainBackendComponent;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use ChatAgency\InputComponentAction\Utilities\Support;
use Closure;

final class InputComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private array|Closure|null $defaultInputTheme = [],
        private ?string $value = null,
        private ?string $error = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        return $this->buildInputComponent($this->input);
    }

    public function buildInputComponent(InputInterface|InputCollectionInterface $input): BackendComponent|ContentComponent
    {

        $recipe = Support::getRecipe($input);
        $inputType = $this->resolveInputType($recipe);
        $themeManager = $recipe->themeManager ?? $this->themeManager;

        /**
         * Init component
         */
        $component = new MainBackendComponent($inputType, $themeManager);

        /**
         * SubComponents
         */
        $subComponents = $this->buildInputSubComponents();

        /**
         * Access necessary values
         */
        $attributes = $recipe->attributeBag?->getInputAttributes() ?? null;
        $theme = $recipe->themeBag?->getInputTheme() ?? $this->defaultInputTheme;
        $callback = $recipe->hookBag?->getInputHook() ?? null;
        $value = $this->value;
        $name = $this->resolveInputName($input);
        $id = $this->resolveInputId($input);

        /**
         * Resolve closures
         */
        $attributes = Support::resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $theme = Support::resolveArrayClosure($theme, input: $input, type: $inputType);

        /**
         * Default attributes
         */
        if (! $recipe->disableDefaultNameAttribute) {
            $component->setAttribute('name', $name);
        }

        if (! $recipe->disableDefaultIdAttribute) {
            $component->setAttribute('id', $id);
        }

        if ($theme) {
            $component->setThemes($theme);
        }

        if ($recipe->labelAsInputContent) {
            $component->setContent($input->getLabel());
        }

        if ($subComponents) {
            $component->setContents($subComponents);
        }

        if (! $recipe->disableInputValue && ! is_null($value)) {
            $component->setAttribute('value', $value);
        }

        /**
         * Set value or
         * selected state
         */
        $selectedOrSelected = $name === $value;

        if ($recipe->checkable && $selectedOrSelected) {
            $component->setAttribute('checked', $selectedOrSelected);
        } elseif ($recipe->selectable && $selectedOrSelected) {
            $component->setAttribute('selected', $selectedOrSelected);
        }

        /**
         * Set/overwrite attributes
         */
        if ($attributes) {
            $component->setAttributes($attributes);
        }

        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback,
            input: $input,
            type: $inputType
        );

        return $component;
    }

    public function buildInputSubComponents(): ?array
    {
        $input = $this->input;

        $subElements = $input->getSubElements();
        $components = [];

        if (! $subElements) {
            return null;
        }

        foreach ($subElements->getInputs() as $element) {
            $components[] = $this->resolveGroup($element);
        }

        return $components;
    }
}
