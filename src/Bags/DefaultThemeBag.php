<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Bags;

use ChatAgency\InputComponentAction\Concerns\HasErrorTheme;
use ChatAgency\InputComponentAction\Concerns\HasHelpTextTheme;
use ChatAgency\InputComponentAction\Concerns\HasLabelTheme;
use ChatAgency\InputComponentAction\Concerns\HasWrapperTheme;
use ChatAgency\InputComponentAction\Concerns\IsThemeBag;
use ChatAgency\InputComponentAction\Contracts\ErrorTheme;
use ChatAgency\InputComponentAction\Contracts\HelpTextTheme;
use ChatAgency\InputComponentAction\Contracts\LabelTheme;
use ChatAgency\InputComponentAction\Contracts\ThemeBag;
use ChatAgency\InputComponentAction\Contracts\WrapperTheme;

final class DefaultThemeBag implements ErrorTheme, HelpTextTheme, LabelTheme, ThemeBag, WrapperTheme
{
    use HasErrorTheme,
        HasHelpTextTheme,
        HasLabelTheme,
        HasWrapperTheme,
        IsThemeBag;
}
