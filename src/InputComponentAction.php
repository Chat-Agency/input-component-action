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
use ChatAgency\InputComponentAction\Bags\DefaultErrorBag;
use ChatAgency\InputComponentAction\Bags\DefaultValueBag;
use ChatAgency\InputComponentAction\Composers\WrapperComposer;
use ChatAgency\InputComponentAction\Containers\OutputContainer;
use ChatAgency\InputComponentAction\Contracts\ErrorBag;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueBag;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;
use Exception;

final class InputComponentAction implements ActionInterface
{
    use IsAction;

    protected $controlsRecursion = true;

    private ?ThemeManager $defaultThemeManager = null;

    private ?InputGroup $defaultInputGroup = null;

    private ?ThemeBag $defaultThemeBag = null;

    private ?object $model = null;

    private ?ValueBag $valueBag = null;

    private ?ErrorBag $errorBag = null;

    public function __construct(
        private array $values = [],
        private array $errors = [],
    ) {
        $this->output = new OutputContainer;

        $this->output->inputs = new DataContainer;
        $this->output->meta = new DataContainer;
    }

    public static function make(array $values = [], array $errors = []): static
    {
        return new self(values: $values, errors: $errors);
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

    public function setModel(?object $model = null): static
    {
        $this->model = $model;

        return $this;
    }

    public function setValueBag(ValueBag $valueBag): static
    {
        $this->valueBag = $valueBag;

        return $this;
    }

    public function setErrorBag(ErrorBag $errorBag): static
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    public function execute(InputCollection|InputInterface|\IteratorAggregate $input)
    {
        /** @var OutputContainer $output */
        $output = $this->output;
        $inputs = $output->inputs;

        $name = $input->getName();

        if (! $name) {
            throw new Exception(message: 'The Input '.$input::class.' must have a name', code: 500);
        }

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

        $inputGroup = $this->getInputGroup($input);

        /** Modifiers on the whole input group component */
        $component = $this->modifiers(
            value: $inputGroup,
            input: $input,
        );

        return $component;

    }

    public function getInputGroup(InputInterface $input): BackendComponent
    {
        $recipe = Support::getRecipe($input);

        return Support::initGroup(
            input: $input,
            recipe: $recipe,
            values: $this->getValueBag($recipe),
            errors: $this->getErrorBag($recipe),
            defaultThemeManager: $this->defaultThemeManager,
            defaultInputGroup: $this->defaultInputGroup,
            defaultThemeBag: $this->defaultThemeBag,
        );

    }

    public function getWrapper(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = Support::getRecipe($input);

        $composer = new WrapperComposer(
            input: $input,
            themeManager: Support::resolveThemeManager($recipe, defaultThemeManager: $this->defaultThemeManager),
            themeBag: $this->defaultThemeBag,
        );

        return $composer->build();
    }

    public function getValueBag(?InputComponentRecipe $recipe): ValueBag
    {
        $bag = $recipe->valueBag ?? $this->valueBag ?? new DefaultValueBag;

        return $bag->setValues($this->values)
            ->setModel($this->model);
    }

    public function getErrorBag(?InputComponentRecipe $recipe): ErrorBag
    {
        $bag = $recipe->errorBag ?? $this->errorBag ?? new DefaultErrorBag;

        return $bag->setErrors($this->errors);
    }

    public function cleanup(): static
    {
        return $this;
    }
}
