<?php

namespace ChatAgency\InputComponentAction\Contracts;

use Closure;
use BackedEnum;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

interface ComponentComposer
{
    public static function resolveInputValue(InputInterface $input, ?string $value = null) : ?string;

    public function resolveGroup(InputInterface $input): BackendComponent;

    public function build(): BackendComponent|ContentComponent|ThemeComponent;

    public function resolveWrapperType(?InputComponentRecipe $recipe) : string|ComponentEnum;

    public function resolveLabelType(?InputComponentRecipe $recipe) : string|ComponentEnum;

    public function resolveInputType(?InputComponentRecipe $recipe) : string|ComponentEnum;

    public function resolveErrorType(?InputComponentRecipe $recipe) : string|ComponentEnum;

    public function resolveComponentClosure(BackendComponent $component, ?Closure $closure, InputInterface $input, BackedEnum $type): BackendComponent|ContentComponent|ThemeComponent;
}