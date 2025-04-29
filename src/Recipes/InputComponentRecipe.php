<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Recipes;

use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Concerns\IsRecipe;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\Contracts\AttributeBag;
use ChatAgency\InputComponentAction\Contracts\HookBag;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\InputComponentAction;
use Closure;

final class InputComponentRecipe implements RecipeInterface
{
    use IsRecipe;

    /** @var class-string */
    protected $action = InputComponentAction::class;

    public function __construct(
        public readonly string|Closure|null $inputValue = null,
        public readonly bool $useParentValue = false,

        public readonly string|Closure|null $inputError = null,

        public readonly ?InputGroup $inputGroup = null,

        public readonly string|Closure|null $label = null,
        public readonly bool $labelAsInputContent = false,
        public readonly bool $emptyLabel = false,

        public readonly ?ComponentEnum $wrapperType = null,
        public readonly ?ComponentEnum $inputType = null,
        public readonly ?ComponentEnum $labelType = null,
        public readonly ?ComponentEnum $errorType = null,

        public readonly ?ThemeManager $themeManager = null,

        public readonly ?AttributeBag $attributeBag = null,
        public readonly ?ThemeBag $themeBag = null,
        public readonly ?HookBag $hookBag = null,

        public readonly bool $disableWrapper = false,
        public readonly bool $disableLabel = false,
        public readonly bool $disableError = false,

        /**
         * Disable attributes created
         * by default
         */
        public readonly bool $disableInputValue = false,
        public readonly bool $disableDefaultNameAttribute = false,
        public readonly bool $disableDefaultIdAttribute = false,
        public readonly bool $disableDefaultForAttribute = false,

        /**
         * Select menu, checkbox of radiobox
         */
        public readonly bool $checkable = false,
        public readonly bool $selectable = false,

        /**
         * Help text
         */
        public readonly string|Closure|null $helpText = null,
        public readonly string|Closure|null $helpTextType = null,

    ) {}
}
