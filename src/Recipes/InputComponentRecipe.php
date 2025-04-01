<?php

namespace ChatAgency\InputComponentAction\Recipes;

use Closure;
use Chatagency\CrudAssistant\Concerns\isRecipe;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\InputComponentAction;

class InputComponentRecipe implements RecipeInterface
{
    use isRecipe;

    private $action = InputComponentAction::class;

    public function __construct(
        public readonly string|ComponentEnum|null $inputType = null,
        public readonly string|Closure|null $inputValue = null,
        public readonly ?Closure $inputCallback = null,
        public readonly array $inputAttributes = [],
        public readonly array $inputTheme = [],
        public readonly bool $labelAsInputContent = false,
        public readonly ?Closure $wrapperCallback = null,
        public readonly array $wrapperTheme = [],
        public readonly string|Closure|null $labelCallback = null,
        public readonly array $labelTheme = [],
        public readonly ?Closure $errorCallback = null,
        public readonly array $errorTheme = [],
        public readonly bool $disableLabel = false,
        public readonly bool $disableError = false,
    )
    {
    }

}
