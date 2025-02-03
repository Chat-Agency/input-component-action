<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

class InputComponentAction extends Action implements ActionInterface 
{
    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input)
    {
        
    }
}
