<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Composers\ErrorComposer;
use ChatAgency\InputComponentAction\Composers\InputComposer;
use ChatAgency\InputComponentAction\Composers\LabelComposer;
use ChatAgency\InputComponentAction\Composers\WrapperComposer;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Utilities\Support;

trait IsInputGroup
{
    private InputInterface $input;

    private ThemeManager $themeManager;

    private ?ThemeBag $defaultThemeBag = null;

    private ?string $value = null;

    private ?string $error = null;

    public function inject(
        InputInterface $input,
        ThemeManager $themeManager,
        ?ThemeBag $defaultThemeBag = null,
        ?string $value = null,
        ?string $error = null,
    ): static {
        $this->input = $input;
        $this->themeManager = $themeManager;
        $this->defaultThemeBag = $defaultThemeBag;
        $this->value = $value;
        $this->error = $error;

        return $this;
    }

    private function getWrapperComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = Support::getRecipe($this->input);

        if ($recipe->disableWrapper) {
            return null;
        }

        $composer = new WrapperComposer(
            input: $this->input,
            themeManager: $this->themeManager,
            defaultWrapperTheme: $this->defaultThemeBag?->getWrapperTheme(),
            value: $this->value,
            error: $this->error,
        );

        return $composer->build();
    }

    private function getLabelComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = Support::getRecipe($this->input);

        if ($recipe->disableLabel) {
            return null;
        }

        $composer = new LabelComposer(
            input: $this->input,
            themeManager: $this->themeManager,
            defaultLabelTheme: $this->defaultThemeBag?->getLabelTheme(),
            value: $this->value,
            error: $this->error,
        );

        return $composer->build();

    }

    private function getInputComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        $composer = new InputComposer(
            input: $this->input,
            themeManager: $this->themeManager,
            defaultInputTheme: $this->defaultThemeBag?->getInputTheme(),
            value: $this->value,
            error: $this->error,
        );

        return $composer->build();
    }

    private function getErrorComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = Support::getRecipe($this->input);

        if ($recipe->disableError) {
            return null;
        }

        $error = new ErrorComposer(
            input: $this->input,
            themeManager: $this->themeManager,
            defaultErrorTheme: $this->defaultThemeBag?->getErrorTheme(),
            value: $this->value,
            error: $this->error,
        );

        return $error->build();
    }
}
