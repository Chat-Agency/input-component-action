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
use ChatAgency\InputComponentAction\Utilities\Support;

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

    public function execute(InputCollection|InputInterface|\IteratorAggregate $input)
    {
        $inputs = $this->output->inputs;

        $name = $input->getName();

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
            values: $this->getValueBag(),
            errors: $this->getErrorBag(),
            defaultThemeBag: $this->defaultThemeBag,
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

    public function getValueBag(): ValueBag
    {
        $bag = $this->valueBag ?? new DefaultValueBag;

        return $bag->setValues($this->values)
            ->setModel($this->model);
    }

    public function getErrorBag(): ErrorBag
    {
        $bag = $this->errorBag ?? new DefaultErrorBag;

        return $bag->setErrors($this->errors);
    }
}
