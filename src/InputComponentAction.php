<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction;

use Illuminate\Contracts\Support\Htmlable;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Concerns\IsAction;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Configs\Groups\DefaultGroup;
use ChatAgency\InputComponentAction\Recipes\InputPresenterRecipe;

final class InputComponentAction implements ActionInterface 
{
    use IsAction;

    protected $controlsRecursion = true;

    public function __construct(
        private array $values = [],
        private array $errors = [],
        /** @todo add accessors */
    ) 
    {
        $this->initOutput();
    }

    public function prepare(): static
    {
        $this->output->inputs = new DataContainer();
        $this->output->meta = new DataContainer();
        
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

    /**
     * Recursively resolve inputs 
     * and input collections.
     */
    public function resolveInputs(InputCollection|InputInterface|\IteratorAggregate $input, bool $wrapped = true): array|BackendComponent|ContentComponent 
    {
        if (CrudAssistant::isInputCollection($input) && $this->controlsRecursion()) {
            
            $wrapper = $this->getWrapper($input);
            
            foreach ($input as $item) {
                $wrapper->setContents($this->resolveInputs($item, false));
            }

            return $wrapper;
        }
        
        
        $recipe = $input->getRecipe($this->getIdentifier()) ?? new InputPresenterRecipe();

        $component = $this->resolveGroup($input);
        
        /**
         * If not wrapped return 
         * array of components.
         */
        if(!$wrapped) {
            return $component;
        }

        $wrapper = $this->getWrapper();
        $wrapper->setContents($component);
        return $wrapper;
        
        
    }
    
    public function resolveGroup(InputInterface $input)
    {
        
        $group = new DefaultGroup();

        $group->setLabel($this->getLabel())
            ->setInput($this->getInput())
            ->setError($this->getError());

        return $group->getGroup();

    }

    public function getLabel(): BackendComponent|ContentComponent|ThemeComponent
    {
        return ComponentBuilder::make(ComponentEnum::LABEL);
            
    }

    public function getInput(): BackendComponent|ContentComponent|ThemeComponent
    {
        return ComponentBuilder::make(ComponentEnum::TEXT_INPUT);
    }

    public function getError(): BackendComponent|ContentComponent|ThemeComponent
    {
        return ComponentBuilder::make(ComponentEnum::PARAGRAPH);
    }

    public function getWrapper(InputInterface $input = null): BackendComponent|ContentComponent|ThemeComponent
    {
        return ComponentBuilder::make(ComponentEnum::DIV);
    }

}
