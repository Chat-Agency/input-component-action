<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use BackedEnum;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;
use Closure;

trait IsComposer
{
    protected ?InputInterface $parent = null;

    public function resolveGroup(InputInterface $input, ?InputInterface $parent = null): BackendComponent
    {
        return Support::initGroup(
            input: $input,
            defaultThemeManager: $this->themeManager,
            defaultInputGroup: null,
            values: $this->values,
            errors: $this->errors,
            defaultThemeBag: null,
            parent: $parent,
        );

    }

    public function setParent(InputInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public static function resolveLabel(InputInterface $input, ?string $value = null, ?string $error = null): string
    {
        $recipe = Support::getRecipe($input);

        $recipeLabel = $recipe->label;

        if (Support::isClosure($recipeLabel)) {
            /** @var string $recipeLabel */
            $recipeLabel = $recipeLabel($input, $value, $error);
        }

        return $recipeLabel ?? $input->getLabel();
    }

    public static function resolveInputName(InputInterface $input, ?array $attributes = null): ?string
    {
        $recipe = Support::getRecipe($input);
        $attributes ??= $recipe->attributeBag?->getInputAttributes() ?? null;

        return $attributes['name'] ?? $name = $input->getName();
    }

    public static function resolveInputId(InputInterface $input, ?array $attributes = null): ?string
    {
        $recipe = Support::getRecipe($input);
        $attributes ??= $recipe->attributeBag?->getInputAttributes() ?? null;

        return $attributes['id'] ?? $name = $input->getName();
    }

    public function resolveWrapperType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe->wrapperType ?? ComponentEnum::DIV;
    }

    public function resolveLabelType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe->labelType ?? ComponentEnum::LABEL;
    }

    public function resolveInputType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe->inputType ?? ComponentEnum::TEXT_INPUT;
    }

    public function resolveErrorType(?InputComponentRecipe $recipe): string|ComponentEnum
    {
        return $recipe->errorType ?? ComponentEnum::PARAGRAPH;
    }

    public function resolveComponentHook(BackendComponent $component, ?Closure $closure, InputInterface $input, BackedEnum $type): BackendComponent|ContentComponent
    {
        if (Support::isClosure($closure)) {
            /** @var array $closure */
            return $closure($component, $input, $type);
        }

        return $component;
    }
}
