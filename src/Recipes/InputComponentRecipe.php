<?php

namespace ChatAgency\InputComponentAction\Recipes;

use ChatAgency\BackendComponents\Themes\LocalThemeManager;
use Closure;
use Chatagency\CrudAssistant\Concerns\isRecipe;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\InputComponentAction;

final class InputComponentRecipe implements RecipeInterface
{
    use isRecipe;

    private $action = InputComponentAction::class;

    public function __construct(
        public readonly string|ComponentEnum|null $inputType = null,
        public readonly string|Closure|null $inputValue = null,
        public readonly ?Closure $inputCallback = null,
        public readonly array $inputAttributes = [],
        public readonly ?array $inputTheme = null,
        public readonly bool $labelAsInputContent = false,
        public readonly string|Closure|null $labelCallback = null,
        public readonly array $labelAttributes = [],
        public readonly ?array $labelTheme = null,
        public readonly ?Closure $wrapperCallback = null,
        public readonly ?array $wrapperTheme = null,
        public readonly ?Closure $errorCallback = null,
        public readonly ?array $errorTheme = null,
        public readonly ?ThemeManager $themeManager = null,
        public readonly bool $disableLabel = false,
        public readonly bool $disableError = false,
    )
    {
    }

}
