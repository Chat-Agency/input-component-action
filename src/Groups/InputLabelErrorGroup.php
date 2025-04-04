<?php

namespace ChatAgency\InputComponentAction\Groups;

use Closure;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Concerns\isInputGroup;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

final class InputLabelErrorGroup
{
    use isInputGroup;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ?string $value = null,
        private ?string $error = null,
        private ?ThemeBag $themeBag = null,
    ) 
    {
    }

    /**
     * @return BackendComponent[]
     */
    public function getGroup() : array
    {
        return [
            $this->getInputComponent(),
            $this->getLabelComponent(),
            $this->getErrorComponent(),
        ];
    }

}
