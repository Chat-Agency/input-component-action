<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Concerns;

use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\BackendComponents\Contracts\ThemeComponent;
use ChatAgency\InputComponentAction\Utilities\Support;
use Composers\HelpTextComposer;

trait HasHelpText
{
    private function getHelpTextComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = Support::getRecipe($this->input);

        if ($recipe->helpText === null) {
            return null;
        }

        $composer = new HelpTextComposer(
            input: $this->input,
            recipe: $this->recipe,
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
