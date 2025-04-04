<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction;

use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Concerns\IsAction;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Utilities\Support;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use Chatagency\CrudAssistant\Contracts\ActionInterface;;
use ChatAgency\InputComponentAction\Groups\DefaultInputGroup;
use ChatAgency\InputComponentAction\Bags\DefaultThemeBag;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Themes\LocalThemeManager;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Composers\WrapperComposer;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

final class InputComponentAction implements ActionInterface 
{
    use IsAction;

    protected $controlsRecursion = true;

    private ?ThemeManager $defaultThemeManager = null;

    private ?InputGroup $defaultInputGroup = null;
    
    private ?ThemeBag $defaultThemeBag = null;

    /** @var DataContainer<DataContainer> */
    protected $output;

    public function __construct(
        private array $values = [],
        private array $errors = [],
        /** @todo add accessors */
    ) 
    {
        $this->initOutput();

        $this->output->inputs = new DataContainer();
        $this->output->meta = new DataContainer();
        
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
        /**
         * @var DataContainer<InputInterface> $inputs
         */
        $inputs = $this->output->inputs;
       
        $inputs->set($input->getName(), $this->resolveInputs($input));

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
        
        $component = $this->resolveGroup($input);
        
        $wrapper = $this->getWrapper($input);
        $wrapper->setContents($component);
        
        return $wrapper;
        
    }
    
    public function resolveGroup(InputInterface $input): array
    {
        $recipe = $this->getRecipe($input);

        $group = $recipe->inputGroup ?? $this->defaultInputGroup ?? new DefaultInputGroup;
        
        $group = $group->inject(
            input: $input, 
            recipe: $this->getRecipe($input),
            themeManager: $this->resolveThemeManager($input),
            defaultThemeBag: $this->getThemeBag($recipe ),
            value: $this->getValue($input),
            error: $this->getError($input),
        );

        return $group->getGroup();

    }

    public function getWrapper(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $composer = new WrapperComposer(
            input: $input,
            recipe: $this->getRecipe($input),
            themeManager: $this->resolveThemeManager($input),
            defaultWrapperTheme: $this->defaultThemeBag->getWrapperTheme(),
        );

        return $composer->build();
    }

    public function getRecipe(InputInterface $input) : InputComponentRecipe
    {
        return $input->getRecipe($this->getIdentifier()) ?? new InputComponentRecipe();
    }
  
    public function getValue(InputInterface $input): ?string
    {
        $name = $input->getName();
        $recipe = $this->getRecipe($input);

        $recipeValue = $recipe->inputValue;
        $value = null;

        if(Support::isClosure($recipeValue)) {
            $value = $recipeValue($input, $this->values);
        } else {
            $value = $recipeValue;
        }

        return $value ?? $this->values[$name] ?? null;
    }

    public function getError(InputInterface $input): ?string
    {
        $name = $input->getName();
        $recipe = $this->getRecipe($input);

        $recipeError = $recipe->inputError;
        $error = null;

        if(Support::isClosure($recipeError)) {
            $error = $recipeError($input, $this->errors);
        } else {
            $error = $recipeError;
        }

        return $error ?? $this->errors[$name] ?? null;
    }

    public function resolveThemeManager(InputInterface $input): ThemeManager
    {
        return $this->getRecipe($input)->defaultThemeManager ?? $this->defaultThemeManager ?? new LocalThemeManager;

    }

    private function getThemeBag(InputComponentRecipe $recipe): ThemeBag
    {
        return $recipe->defaultThemeBag ?? $this->defaultThemeBag ?? new DefaultThemeBag();
    }

}