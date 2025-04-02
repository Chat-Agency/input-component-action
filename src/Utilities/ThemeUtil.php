<?php

namespace ChatAgency\InputComponentAction\Utilities;

use Closure;
use BackedEnum;

final class ThemeUtil
{
    public static function resolveTheme(array|Closure|null $theme, BackedEnum|string $type): ?array
    {
        if($theme instanceof Closure) {
            /** @var array $theme */
            return $theme($type);
        }

        return $theme;
    }
}
