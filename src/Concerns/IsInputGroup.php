<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Composers\InputComposer;
use ChatAgency\InputComponentAction\Contracts\ErrorManager;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueManager;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

trait IsInputGroup
{
    private InputInterface $input;

    private InputComponentRecipe $recipe;

    private ThemeManager $themeManager;

    private InputGroup $defaultInputGroup;

    private ValueManager $values;

    private ErrorManager $errors;

    private ?ThemeBag $defaultThemeBag = null;

    private ?InputInterface $parent = null;

    public function inject(
        InputInterface $input,
        InputComponentRecipe $recipe,
        ThemeManager $themeManager,
        InputGroup $defaultInputGroup,
        ValueManager $values,
        ErrorManager $errors,
        ?ThemeBag $defaultThemeBag = null,
    ): static {
        $this->input = $input;
        $this->recipe = $recipe;
        $this->themeManager = $themeManager;
        $this->defaultInputGroup = $defaultInputGroup;
        $this->values = $values;
        $this->errors = $errors;
        $this->defaultThemeBag = $defaultThemeBag;

        return $this;
    }

    public function setParent(InputInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    private function getInputComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        $composer = new InputComposer(
            input: $this->input,
            recipe: $this->recipe,
            themeManager: $this->themeManager,
            defaultInputGroup: $this->defaultInputGroup,
            values: $this->values,
            errors: $this->errors,
            themeBag: $this->defaultThemeBag,
        );

        if ($this->parent) {
            $composer->setParent($this->parent);
        }

        return $composer->build();
    }
}
