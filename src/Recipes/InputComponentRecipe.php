<?php

namespace ChatAgency\InputComponentAction\Recipes;

use Closure;
use Chatagency\CrudAssistant\Concerns\isRecipe;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Contracts\AttributeBag;
use ChatAgency\InputComponentAction\Contracts\ClosureBag;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\InputComponentAction;

final class InputComponentRecipe implements RecipeInterface
{
    use isRecipe;

    private $action = InputComponentAction::class;

    public function __construct(
        public readonly string|Closure|null $inputValue = null,
        public readonly string|Closure|null $inputError = null,

        public readonly ?InputGroup $inputGroup = null,
        
        public readonly bool $labelAsInputContent = false,
        
        public readonly ?ComponentEnum $wrapperType = null,
        public readonly ?ComponentEnum $inputType = null,
        public readonly ?ComponentEnum $labelType = null,
        public readonly ?ComponentEnum $errorType = null,

        public readonly ?ThemeManager $themeManager = null,
        
        public readonly ?AttributeBag $attributeBag = null,
        public readonly ?ThemeBag $themeBag = null,
        public readonly ?ClosureBag $closureBag = null,

        public readonly bool $disableWrapper = false,
        public readonly bool $disableLabel = false,
        public readonly bool $disableError = false,

        /** 
         * Disables adding the name and 
         * id to the input by default
        */
        public readonly bool $disableInputDefaultAttributes = false,
    )
    {
    }

}
