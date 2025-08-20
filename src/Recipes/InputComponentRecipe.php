<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Recipes;

use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Concerns\IsRecipe;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\Contracts\AttributeBag;
use ChatAgency\InputComponentAction\Contracts\BuilderBag;
use ChatAgency\InputComponentAction\Contracts\ErrorAttributes;
use ChatAgency\InputComponentAction\Contracts\ErrorBuilder;
use ChatAgency\InputComponentAction\Contracts\ErrorHook;
use ChatAgency\InputComponentAction\Contracts\ErrorManager;
use ChatAgency\InputComponentAction\Contracts\ErrorTheme;
use ChatAgency\InputComponentAction\Contracts\HelpTextAttributes;
use ChatAgency\InputComponentAction\Contracts\HelpTextBuilder;
use ChatAgency\InputComponentAction\Contracts\HelpTextHook;
use ChatAgency\InputComponentAction\Contracts\HelpTextTheme;
use ChatAgency\InputComponentAction\Contracts\HookBag;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Contracts\LabelAttributes;
use ChatAgency\InputComponentAction\Contracts\LabelBuilder;
use ChatAgency\InputComponentAction\Contracts\LabelHook;
use ChatAgency\InputComponentAction\Contracts\LabelTheme;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueManager;
use ChatAgency\InputComponentAction\Contracts\WrapperAttributes;
use ChatAgency\InputComponentAction\Contracts\WrapperBuilder;
use ChatAgency\InputComponentAction\Contracts\WrapperHook;
use ChatAgency\InputComponentAction\Contracts\WrapperTheme;
use ChatAgency\InputComponentAction\InputComponentAction;
use Closure;

final class InputComponentRecipe implements RecipeInterface
{
    use IsRecipe;

    /** @var class-string */
    protected $action = InputComponentAction::class;

    public function __construct(
        public readonly string|int|Closure|null $inputValue = null,
        public readonly bool $useParentValue = false,

        public readonly string|Closure|null $inputError = null,

        public readonly ?InputGroup $inputGroup = null,

        public readonly string|Closure|null $label = null,
        public readonly bool $labelAsInputContent = false,
        public readonly bool $emptyLabel = false,
        public readonly bool $valueAsInputContent = false,

        public readonly string|Closure|null $helpText = null,

        public readonly ?ComponentEnum $wrapperType = null,
        public readonly ?ComponentEnum $inputType = null,
        public readonly ?ComponentEnum $labelType = null,
        public readonly ?ComponentEnum $errorType = null,
        public readonly ?ComponentEnum $helpTextType = null,

        public readonly ?ThemeManager $themeManager = null,

        public readonly BuilderBag|WrapperBuilder|LabelBuilder|ErrorBuilder|HelpTextBuilder|null $builderBag = null,

        public readonly AttributeBag|WrapperAttributes|LabelAttributes|ErrorAttributes|HelpTextAttributes|null $attributeBag = null,
        public readonly ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $themeBag = null,
        public readonly HookBag|WrapperHook|LabelHook|ErrorHook|HelpTextHook|null $hookBag = null,

        public readonly bool $disableWrapper = false,
        public readonly bool $disableLabel = false,
        public readonly bool $disableError = false,
        public readonly bool $disableHelpText = false,

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

        public readonly ?ValueManager $valueBag = null,
        public readonly ?ErrorManager $errorBag = null,

    ) {}
}
