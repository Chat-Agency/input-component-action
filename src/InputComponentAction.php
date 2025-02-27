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
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Groups\DefaultGroup;
use ChatAgency\InputComponentAction\Recipes\InputPresenterRecipe;

final class InputComponentAction implements ActionInterface 
{
    use IsAction;

    private int $count = 0;

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
        
        $group = new DefaultGroup();

        $group->setLabel($this->getLabelComponent($input))
            ->setInput($this->getInputComponent($input))
            ->setError($this->getErrorComponent($input));

        return $group->getGroup();

    }

    public function getLabelComponent(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = $this->getRecipe($input);
        $component = ComponentBuilder::make(ComponentEnum::LABEL);

        $label = $recipe->label ?? $input->getLabel();
        $for = $input->getName();

        $component->setContent($label)
            ->setAttribute('for', $for);

        return $component;
            
    }

    public function getInputComponent(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = $this->getRecipe($input);
        
        $name = $input->getLabel();
        $id = $input->getName();
        $value = $recipe->value ?? $this->getValue($input);
        $type = $recipe->type ?? ComponentEnum::TEXT_INPUT;

        $component = ComponentBuilder::make($type);

        $component->setAttribute('name', $name)
            ->setAttribute('id', $id)
            ->setAttribute('value', $value)
            ->setAttribute('type', 'text');

        return $component;
    }

    public function getErrorComponent(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = $this->getRecipe($input);
        $component = ComponentBuilder::make(ComponentEnum::PARAGRAPH);

        return $component;
    }

    public function getWrapper(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = $this->getRecipe($input);
        $component = ComponentBuilder::make(ComponentEnum::DIV);

        return $component;
    }

    public function getRecipe(InputInterface $input) : InputPresenterRecipe
    {
        return $input->getRecipe($this->getIdentifier()) ?? new InputPresenterRecipe();
    }
  
    public function getValue(InputInterface $inputInterface): string
    {
        return '';
    }

    public function getError(InputInterface $inputInterface): string
    {
        return '';
    }
}
