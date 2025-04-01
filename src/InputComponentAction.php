<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction;

use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Concerns\IsAction;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;;
use ChatAgency\InputComponentAction\Groups\DefaultGroup;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

final class InputComponentAction implements ActionInterface 
{
    use IsAction;

    /** @var DataContainer<string, DataContainer> */
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

    public function prepare(): static
    {
        return $this;
    }

    public function cleanup(): static
    {
        return $this;
    }

    public function controlsRecursion()
    {
        return true;
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

    /**
     * Recursively resolve inputs 
     * and input collections.
     */
    public function resolveInputs(InputCollection|InputInterface|\IteratorAggregate $input): array|BackendComponent|ContentComponent 
    {
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
        
        $group = new DefaultGroup(
            input: $input, 
            recipe: $this->getRecipe($input),
            identifier: $this->getIdentifier(),
            value: $this->getValue($input),
            error: $this->getError($input),
        );

        return $group->getGroup();

    }

    public function getWrapper(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = $this->getRecipe($input);
        $component = ComponentBuilder::make(ComponentEnum::DIV);

        return $component;
    }

    public function getRecipe(InputInterface $input) : InputComponentRecipe
    {
        return $input->getRecipe($this->getIdentifier()) ?? new InputComponentRecipe();
    }
  
    public function getValue(InputInterface $inputInterface): ?string
    {
        return null;
    }

    public function getError(InputInterface $inputInterface): ?string
    {
        return null;
    }
}
