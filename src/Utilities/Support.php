<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Utilities;

use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use ChatAgency\BackendComponents\Themes\LocalThemeManager;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\Bags\DefaultThemeBag;
use ChatAgency\InputComponentAction\Contracts\ErrorBag;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueBag;
use ChatAgency\InputComponentAction\Groups\DefaultInputGroup;
use ChatAgency\InputComponentAction\InputComponentAction;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use Closure;

final class Support
{
    public static function getRecipe(InputInterface $input): InputComponentRecipe
    {
        return $input->getRecipes()[InputComponentAction::getIdentifier()] ?? new InputComponentRecipe;
    }

    public static function initGroup(InputInterface $input, InputComponentRecipe $recipe, ?ThemeManager $defaultThemeManager = null, ?InputGroup $defaultInputGroup = null, ?ThemeBag $defaultThemeBag = null, ?ValueBag $values = null, ?ErrorBag $errors = null, ?InputInterface $parent = null): BackendComponent
    {
        $group = $recipe->inputGroup ?? $defaultInputGroup ?? new DefaultInputGroup;

        $group = $group->inject(
            input: $input,
            recipe: $recipe,
            themeManager: $defaultThemeManager ?? self::resolveThemeManager($recipe),
            defaultInputGroup: $defaultInputGroup ?? new DefaultInputGroup,
            values: $values,
            errors: $errors,
            defaultThemeBag: self::resolveThemeBag($recipe, $defaultThemeBag),
        );

        if ($parent) {

            $group->setParent($parent);
        }

        return $group->getGroup();

    }

    public static function resolveThemeManager(RecipeInterface $recipe, $defaultThemeManager = null): ThemeManager
    {
        return $recipe->defaultThemeManager ?? $defaultThemeManager ?? new LocalThemeManager;
    }

    private static function resolveThemeBag(RecipeInterface $recipe, ?ThemeBag $defaultThemeBag = null): ThemeBag
    {
        return $recipe->defaultThemeBag ?? $defaultThemeBag ?? new DefaultThemeBag;
    }

    public static function isClosure(mixed $value): bool
    {
        return $value instanceof Closure;
    }

    public static function getCollectionWrapper(): BackendComponent|ContentComponent
    {
        return ComponentBuilder::make(ComponentEnum::COLLECTION);
    }
}
