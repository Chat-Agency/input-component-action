<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction;

use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Concerns\IsAction;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use ChatAgency\InputComponentAction\Components\GroupComponent;
use ChatAgency\InputComponentAction\Configs\ComponentConfig;
use ChatAgency\InputComponentAction\Recipes\InputPresenterRecipe;
use Illuminate\Contracts\Support\Htmlable;

class InputComponentAction implements ActionInterface 
{
    use IsAction;

    public function __construct(
        private array $values = [],
    ) 
    {
        
    }

    public function prepare(): static
    {
        $this->initOutput();

        $this->output->inputs = new DataContainer();
        $this->output->meta = new DataContainer();
        
        return $this;
    }

    public function execute(InputCollection|InputInterface|\IteratorAggregate $input)
    {
        $output = $this->getOutput();
        /**
         * @var DataContainer<InputInterface> $inputs
         */
        $inputs = $this->output->inputs;
        
        $recipe = $input->getRecipe($this->getIdentifier()) ?? new InputPresenterRecipe();
        
        // $component = $this->resolveComponents($input, $recipe);
        
        // $inputs->set($input->getName(), $component);
        
        return $output;
    }
    
    public function resolveComponents(InputInterface $input, InputPresenterRecipe $recipe)
    {
        // return (new GroupComponent( $input, $recipe->config))->getGroup();
        

    }


}
