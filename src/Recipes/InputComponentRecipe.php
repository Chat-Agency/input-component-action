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
use ChatAgency\InputComponentAction\InputComponentAction;

final class InputComponentRecipe implements RecipeInterface
{
    use isRecipe;

    private $action = InputComponentAction::class;

    public function __construct(
        public readonly ?ComponentEnum $inputType = null,
        public readonly string|Closure|null $inputValue = null,
        public readonly string|Closure|null $inputError = null,

        public readonly bool $labelAsInputContent = false,
        
        public readonly ?ThemeManager $themeManager = null,
        
        public readonly ?AttributeBag $attributeBag = null,
        public readonly ?ThemeBag $themeBag = null,
        public readonly ?ClosureBag $closureBag = null,
    )
    {
    }

}
