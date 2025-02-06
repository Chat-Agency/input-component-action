<?php

namespace ChatAgency\InputComponentAction\Recipes;

use ChatAgency\InputComponentAction\Configs\ComponentConfig;
use Closure;
use Chatagency\CrudAssistant\Concerns\isRecipe;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\InputComponentAction;

class InputPresenterRecipe implements RecipeInterface
{
    use isRecipe;

    public function __construct(
        
    ) 
    {
        
    }

    protected $action = InputComponentAction::class;

}
