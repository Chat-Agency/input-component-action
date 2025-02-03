<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Recipes;

use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeBase;
use ChatAgency\InputComponentAction\InputComponentAction;
use Closure;

class InputPresenterRecipe extends RecipeBase implements RecipeInterface
{
    public string $title;

    public $helpText;

    public string $invalidFeedback;

    public array $labelAttributes;

    public array $extra;

    /**
     * @var string|Closure
     */
    public $theme;

    public $label;

    public $prepend;

    public $append;

    /**
     * @var string|Closure
     */
    public $value;

    public array $accessors;

    /**
     * Recipe action
     *
     * @var string
     */
    protected $action = InputComponentAction::class;
}
