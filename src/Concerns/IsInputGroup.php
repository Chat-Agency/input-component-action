<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Composers\InputComposer;
use ChatAgency\InputComponentAction\Contracts\ErrorBag;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\ValueBag;

trait IsInputGroup
{
    private InputInterface $input;

    private ThemeManager $themeManager;

    private ValueBag $values;

    private ErrorBag $errors;

    private ?ThemeBag $defaultThemeBag = null;

    private ?InputInterface $parent = null;

    public function inject(
        InputInterface $input,
        ThemeManager $themeManager,
        ValueBag $values,
        ErrorBag $errors,
        ?ThemeBag $defaultThemeBag = null,
    ): static {
        $this->input = $input;
        $this->themeManager = $themeManager;
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
            themeManager: $this->themeManager,
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
