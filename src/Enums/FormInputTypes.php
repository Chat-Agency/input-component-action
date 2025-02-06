<?php

namespace ChatAgency\InputComponentAction\Enums;

use ChatAgency\BackendComponents\Enums\ComponentEnum;

class FormInputTypes
{
    const form = ComponentEnum::FORM;
    const label = ComponentEnum::LABEL;
    const legend = ComponentEnum::LEGEND;
    const fieldset = ComponentEnum::FIELDSET;
    const text = ComponentEnum::TEXT_INPUT;
    const file = ComponentEnum::FILE_INPUT;
    const email = ComponentEnum::EMAIL_INPUT;
    const search = ComponentEnum::SEARCH_INPUT;
    const checkbox = ComponentEnum::CHECKBOX_INPUT;
    const hidden = ComponentEnum::HIDDEN_INPUT;
    const radio = ComponentEnum::RADIO_INPUT;
    const textarea = ComponentEnum::TEXTAREA;
    const select = ComponentEnum::SELECT;
    const optgroup = ComponentEnum::OPTGROUP;
    const option = ComponentEnum::OPTION;

}
