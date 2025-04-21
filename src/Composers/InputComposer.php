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
use ChatAgency\InputComponentAction\Bags\DefaultErrorBag;
use ChatAgency\InputComponentAction\Bags\DefaultValueBag;
use ChatAgency\InputComponentAction\Concerns\IsComposer;
use ChatAgency\InputComponentAction\Contracts\ComponentComposer;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;
use Closure;

final class InputComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private ?DefaultValueBag $values = null,
        private ?DefaultErrorBag $errors = null,
        private array|Closure|null $defaultInputTheme = [],
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
        $valueResolver = $this->values;

        /**
         * Init component
         */
        $component = new MainBackendComponent($inputType, $themeManager);

        /**
         * SubComponents
         */
        $subComponents = $this->buildSubComponentGroup();

        /**
         * Access
         */
        $attributes = $recipe->attributeBag?->getInputAttributes() ?? null;
        $theme = $recipe->themeBag?->getInputTheme() ?? $this->defaultInputTheme;
        $callback = $recipe->hookBag?->getInputHook() ?? null;

        $value = $valueResolver->resolve($input, $recipe);
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

    public function buildSubComponentGroup(): ?array
    {
        $input = $this->input;

        $subElements = $input->getSubElements();
        $components = [];

        if (! $subElements) {
            return null;
        }

        foreach ($subElements->getInputs() as $element) {
            $components[] = $this->resolveGroup($element, $input);
        }

        return $components;
    }

    public function addCheckableAndSelectableAttribute(InputInterface $input, InputComponentRecipe $recipe, BackendComponent $component, DefaultValueBag $valueResolver, ?string $value = null): void
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
