<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Recipes;

use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Concerns\IsRecipe;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\Contracts\AttributeBag;
use ChatAgency\InputComponentAction\Contracts\ClosureBag;
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
        public readonly string|Closure|null $inputError = null,

        public readonly ?InputGroup $inputGroup = null,

        public readonly string|Closure|null $label = null,
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
        public readonly bool $disableDefaultNameAttribute = false,
        public readonly bool $disableDefaultIdAttribute = false,

        public readonly bool $ckeckable = false,
        public readonly bool $selectable = false,

        public readonly bool $isInputGroup = false,
    ) {}
}
