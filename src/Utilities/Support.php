<?php

namespace ChatAgency\InputComponentAction\Utilities;

use Closure;
use BackedEnum;
use ChatAgency\BackendComponents\Contracts\BackendComponent;
use Chatagency\CrudAssistant\Contracts\InputInterface;

class Support
{

    public static function resolveArrayClosure(array|Closure|null $value, InputInterface $input, BackedEnum $type): array
    {
        if($input === null) {
            return [];
        }
        
        if(Support::isClosure($value)) {
            /** @var array $value */
            return $value($input, $type);
        }

        return $value;
    }

    public static function isClosure(mixed $value): bool
    {
        return $value instanceof Closure;
    }
}
