<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Contracts;

use BackedEnum;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;
use Closure;

interface ComponentComposer
{
    public function resolveGroup(InputInterface $input): BackendComponent;

    public function build(): BackendComponent|ContentComponent|ThemeComponent;

    public function resolveWrapperType(?InputComponentRecipe $recipe): string|ComponentEnum;

    public function resolveLabelType(?InputComponentRecipe $recipe): string|ComponentEnum;

    public function resolveInputType(?InputComponentRecipe $recipe): string|ComponentEnum;

    public function resolveErrorType(?InputComponentRecipe $recipe): string|ComponentEnum;

    public function resolveComponentHook(BackendComponent $component, ?Closure $closure, InputInterface $input, BackedEnum $type): BackendComponent|ContentComponent|ThemeComponent;
}
