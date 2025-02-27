<?php

namespace ChatAgency\InputComponentAction\Recipes;

use Closure;
use Chatagency\CrudAssistant\Concerns\isRecipe;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\InputComponentAction;

class InputPresenterRecipe implements RecipeInterface
{
    use isRecipe;

    protected $action = InputComponentAction::class;

    public function __construct(
        public readonly string|ComponentEnum|null $inputType = null,
        public readonly ?Closure $value = null,
        public readonly ?Closure $input = null,
        public readonly array $inputTheme = [],
        public readonly ?Closure $wrapper = null,
        public readonly array $wrapperTheme = [],
        public readonly string|Closure|null $label = null,
        public readonly array $labelTheme = [],
        public readonly ?Closure $error = null,
        public readonly bool $disableLabel = false,
        public readonly bool $disableError = false,
    )
    {
    }

}
