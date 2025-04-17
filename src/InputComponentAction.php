<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use Chatagency\CrudAssistant\Concerns\IsAction;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use ChatAgency\InputComponentAction\Composers\WrapperComposer;
use ChatAgency\InputComponentAction\Containers\OutputContainer;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Utilities\Support;

final class InputComponentAction implements ActionInterface
{
    use IsAction;

    protected $controlsRecursion = true;

    private ?ThemeManager $defaultThemeManager = null;

    private ?InputGroup $defaultInputGroup = null;

    private ?ThemeBag $defaultThemeBag = null;

    public function __construct(
        private ?object $model = null,
        private array $values = [],
        private array $errors = [],
    ) {
        $this->output = new OutputContainer;

        $this->output->inputs = new DataContainer;
        $this->output->meta = new DataContainer;

    }

    public function setThemeManager(ThemeManager $defaultThemeManager): static
    {
        $this->defaultThemeManager = $defaultThemeManager;

        return $this;
    }

    public function setDefaultInputGroup(InputGroup $defaultInputGroup): static
    {
        $this->defaultInputGroup = $defaultInputGroup;

        return $this;
    }

    public function setDefaultThemeBag(ThemeBag $defaultThemeBag): static
    {
        $this->defaultThemeBag = $defaultThemeBag;

        return $this;
    }

    public function execute(InputCollection|InputInterface|\IteratorAggregate $input)
    {
        $inputs = $this->output->inputs;

        $name = Support::getName($input);

        $inputs->set($name, $this->resolveInputs($input));

        return $this->output;
    }

    public function resolveInputs(InputCollection|InputInterface|\IteratorAggregate $input): array|BackendComponent|ContentComponent
    {
        /**
         * Recursively resolve inputs
         * and input collections.
         */
        if (CrudAssistant::isInputCollection($input) && $this->controlsRecursion()) {
            $wrapper = $this->getWrapper($input);

            foreach ($input as $item) {
                $wrapper->setContent($this->resolveInputs($item));
            }

            return $wrapper;
        }

        /** Modifiers on the whole input group component */
        $component = $this->modifiers(
            value: $this->getGroup($input),
            input: $input,
        );

        return $component;

    }

    public function getGroup(InputInterface $input): BackendComponent
    {
        return Support::initGroup(
            input: $input,
            defaultThemeManager: $this->defaultThemeManager,
            defaultInputGroup: $this->defaultInputGroup,
            defaultThemeBag: $this->defaultThemeBag,
            value: $this->getValue($input),
            error: $this->getError($input),
        );

    }

    public function getWrapper(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = Support::getRecipe($input);

        $composer = new WrapperComposer(
            input: $input,
            themeManager: Support::resolveThemeManager($recipe, defaultThemeManager: $this->defaultThemeManager),
            defaultWrapperTheme: $this->defaultThemeBag->getWrapperTheme(),
        );

        return $composer->build();
    }

    public function getValue(InputInterface $input, ?object $model = null): ?string
    {
        /**
         * @todo Work on model
         */
        $name = Support::getName($input);
        $recipe = Support::getRecipe($input);

        $modelValue = $model->{$name} ?? null;

        $recipeValue = $recipe->inputValue;
        $value = null;

        if (Support::isClosure($recipeValue)) {
            $value = $recipeValue($input, $this->values);
        } else {
            $value = $recipeValue;
        }

        return $value ?? $this->values[$name] ?? $modelValue ?? null;
    }

    public function getError(InputInterface $input): ?string
    {
        $name = Support::getName($input);
        $recipe = Support::getRecipe($input);

        $recipeError = $recipe->inputError;
        $error = null;

        if (Support::isClosure($recipeError)) {
            $error = $recipeError($input, $this->errors);
        } else {
            $error = $recipeError;
        }

        return $error ?? $this->errors[$name] ?? null;
    }
}
