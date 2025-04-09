<?php

namespace ChatAgency\InputComponentAction\Utilities;

use Closure;
use Exception;
use BackedEnum;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\BackendComponents\Contracts\ThemeManager;
use ChatAgency\InputComponentAction\Bags\DefaultThemeBag;
use ChatAgency\InputComponentAction\Contracts\InputGroup;
use ChatAgency\InputComponentAction\InputComponentAction;
use ChatAgency\BackendComponents\Themes\LocalThemeManager;
use ChatAgency\BackendComponents\Builders\ComponentBuilder;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use ChatAgency\BackendComponents\Contracts\ContentComponent;
use ChatAgency\InputComponentAction\Groups\DefaultInputGroup;
use ChatAgency\InputComponentAction\Recipes\InputComponentRecipe;

class Support
{
    
    
    public static function getRecipe(InputInterface $input) : InputComponentRecipe
    {
        return $input->getRecipe(InputComponentAction::getIdentifier()) ?? new InputComponentRecipe();
    }
    

    public static function resolveGroup(InputInterface $input, InputGroup $defaultInputGroup = null, ThemeManager $defaultThemeManager = null, ThemeBag $defaultThemeBag = null, ?string $value = null, ?string $error = null): BackendComponent
    {
        $recipe = self::getRecipe($input);
        
        $group = $recipe->inputGroup ?? $defaultInputGroup ?? new DefaultInputGroup;
        
        $group = $group->inject(
            input: $input, 
            themeManager: $defaultThemeManager ?? self::resolveThemeManager($recipe),
            defaultThemeBag: self::resolveThemeBag($recipe, $defaultThemeBag),
            value: $value,
            error: $error,
        );

        return $group->getGroup();

    }  

    public static function resolveThemeManager(InputComponentRecipe $recipe, $defaultThemeManager = null): ThemeManager
    {
        return $recipe->defaultThemeManager ?? $defaultThemeManager ?? new LocalThemeManager;
    }

    private static function resolveThemeBag(InputComponentRecipe $recipe, ?ThemeBag $defaultThemeBag = null): ThemeBag
    {
        return $recipe->defaultThemeBag ?? $defaultThemeBag ?? new DefaultThemeBag();
    }

    public static function resolveArrayClosure(array|Closure|null $value, InputInterface $input, BackedEnum $type): ?array
    {
        if($input === null) {
            return null;
        }
        
        if(self::isClosure($value)) {
            /** @var array $value */
            return $value($input, $type);
        }

        return $value;
    }

    public static function isClosure(mixed $value): bool
    {
        return $value instanceof Closure;
    }

    public static function getCollectionWrapper() : BackendComponent|ContentComponent
    {
        return ComponentBuilder::make(ComponentEnum::COLLECTION);
    }

    /**
     * @throws Exception
     */
    public static function getName(InputInterface $input): string
    {
        $name = $input->getName();

        if(!$name) {
            throw new Exception('All inputs and collections must have name', 500);
        }
       
        return $name;
    }
}
