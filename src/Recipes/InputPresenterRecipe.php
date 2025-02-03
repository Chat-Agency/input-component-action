<?php

namespace ChatAgency\InputComponentAction\Recipes;

use Closure;
use Chatagency\CrudAssistant\RecipeBase;
use App\Cruds\Actions\Form\InputPresenterAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use ChatAgency\InputComponentAction\InputComponentAction;

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
