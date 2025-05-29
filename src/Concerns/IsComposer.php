<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use BackedEnum;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\Contracts\ErrorManager;
use ChatAgency\InputComponentAction\Contracts\ValueManager;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use ChatAgency\InputComponentAction\Utilities\Support;
use Closure;

trait IsComposer
{
    private ?InputInterface $parent = null;

    public function setParent(InputInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    private static function resolveStringClosure(InputInterface $input, string|Closure|null $stringClosure, ?string $value = null, ?string $error = null): string
    {
        if (Support::isClosure($stringClosure)) {
            $stringClosure = $stringClosure($input, $value, $error);
        }

        return $stringClosure;
    }

    private static function resolveArrayClosure(array|Closure|null $value, InputInterface $input, BackedEnum $type): ?array
    {
        if ($input == null) {
            return null;
        }

        if (Support::isClosure($value)) {
            return $value($input, $type);
        }

        return $value;
    }

    private static function resolveInputName(InputInterface $input, InputComponentRecipe $recipe, ?array $attributes = null): ?string
    {
        $attributes ??= $recipe->attributeBag?->getInputAttributes() ?? null;

        return $attributes['name'] ?? $input->getName();
    }

    private static function resolveInputId(InputInterface $input, InputComponentRecipe $recipe, ?array $attributes = null): ?string
    {
        $attributes ??= $recipe->attributeBag?->getInputAttributes() ?? null;

        return $attributes['id'] ?? $input->getName();
    }

    private function resolveWrapperType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe->wrapperType ?? ComponentEnum::DIV;
    }

    private function resolveLabelType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe->labelType ?? ComponentEnum::LABEL;
    }

    private function resolveInputType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe->inputType ?? ComponentEnum::TEXT_INPUT;
    }

    private function resolveErrorType(?InputComponentRecipe $recipe): string|ComponentEnum
    {
        return $recipe->errorType ?? ComponentEnum::PARAGRAPH;
    }

    private function resolveComponentHook(
        BackendComponent $component,
        ?Closure $closure,
        InputInterface $input,
        BackedEnum $type,
        ?ValueManager $values = null,
        ?ErrorManager $errors = null,
    ): BackendComponent|ContentComponent {
        if (Support::isClosure($closure)) {
            $result = $closure(
                $component,
                $input,
                $type,
                $values,
                $errors
            );

            return $result;
        }

        return $component;
    }
}
