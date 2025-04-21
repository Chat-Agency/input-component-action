<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Bags\DefaultErrorBag;
use ChatAgency\InputComponentAction\Bags\DefaultValueBag;
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

    private DefaultValueBag $values;

    private DefaultErrorBag $errors;

    private ?ThemeBag $defaultThemeBag = null;

    public function inject(
        InputInterface $input,
        ThemeManager $themeManager,
        DefaultValueBag $values,
        DefaultErrorBag $errors,
        ?ThemeBag $defaultThemeBag = null,
    ): static {
        $this->input = $input;
        $this->themeManager = $themeManager;
        $this->values = $values;
        $this->errors = $errors;
        $this->defaultThemeBag = $defaultThemeBag;

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
            values: $this->values,
            errors: $this->errors,
            defaultWrapperTheme: $this->defaultThemeBag?->getWrapperTheme(),
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
            values: $this->values,
            errors: $this->errors,
            defaultLabelTheme: $this->defaultThemeBag?->getLabelTheme(),
        );

        return $composer->build();

    }

    private function getInputComponent(): BackendComponent|ContentComponent|ThemeComponent
    {
        $composer = new InputComposer(
            input: $this->input,
            themeManager: $this->themeManager,
            values: $this->values,
            errors: $this->errors,
            defaultInputTheme: $this->defaultThemeBag?->getInputTheme(),
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
            values: $this->values,
            errors: $this->errors,
            defaultErrorTheme: $this->defaultThemeBag?->getErrorTheme(),
        );

        return $error->build();
    }
}
