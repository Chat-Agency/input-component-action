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
use ChatAgency\InputComponentAction\Contracts\ErrorBag;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueBag;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;

final class InputComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private InputGroup $defaultInputGroup,
        private ?ValueBag $values = null,
        private ?ErrorBag $errors = null,
        private ?ThemeBag $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        return $this->buildInputComponent($this->input);
    }

    public function buildInputComponent(InputInterface|InputCollectionInterface $input): BackendComponent|ContentComponent
    {

        $recipe = $this->recipe;
        $inputType = $this->resolveInputType($recipe);
        $themeManager = $recipe->themeManager ?? $this->themeManager;
        $valueResolver = $this->values;

        /**
         * Init component
         */
        $component = new MainBackendComponent($inputType, $themeManager);

        /**
         * SubComponents
         */
        $subComponents = $this->buildSubComponentGroup($recipe);

        /**
         * Access
         */
        $attributes = $recipe->attributeBag?->getInputAttributes() ?? null;
        $theme = $recipe->themeBag?->getInputTheme() ?? $this->themeBag?->getInputTheme();
        $callback = $recipe->hookBag?->getInputHook() ?? null;

        $value = $valueResolver->resolve($input, $recipe);
        $name = $this->resolveInputName($input, $recipe);
        $id = $this->resolveInputId($input, $recipe);

        /**
         * Resolve closures
         */
        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $theme = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);

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

        if (! $recipe->disableInputValue) {
            $component->setAttribute('value', $value);
        }

        /**
         * Checkable and selectable inputs
         */
        $this->addCheckableAndSelectableAttribute($input, $recipe, $component, $valueResolver, $value);

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

    public function buildSubComponentGroup(InputComponentRecipe $recipe): ?array
    {
        $input = $this->input;

        $subElements = $input->getSubElements();
        $components = [];

        if (! $subElements) {
            return null;
        }

        foreach ($subElements->getInputs() as $element) {
            $elementRecipe = Support::getRecipe($element);
            $components[] = $this->resolveGroup($element, $elementRecipe, $input);
        }

        return $components;
    }

    public function addCheckableAndSelectableAttribute(InputInterface $input, InputComponentRecipe $recipe, BackendComponent $component, ValueBag $valueResolver, ?string $value = null): void
    {
        if ($recipe->checkable || $recipe->selectable) {

            $isSelected = false;

            if ($recipe->useParentValue && $this->parent) {
                $parentValue = $valueResolver->resolve($this->parent, Support::getRecipe($this->parent));
                $isSelected = $value == $parentValue;
            } else {
                $isSelected = $valueResolver->resolve($input, $recipe, true);
            }

            if ($recipe->selectable && $isSelected) {
                $component->setAttribute('selected', 'selected');
            }

            if ($recipe->checkable && $isSelected) {
                $component->setAttribute('checked', 'checked');
            }
        }
    }
}
