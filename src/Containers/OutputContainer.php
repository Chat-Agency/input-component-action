<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Containers;

use ArrayAccess;
use Chatagency\CrudAssistant\Concerns\IsDataContainer;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\DataContainer;
use Countable;
use IteratorAggregate;

final class OutputContainer implements ArrayAccess, Countable, DataContainerInterface, IteratorAggregate
{
    use IsDataContainer;

    public DataContainer $inputs;

    public DataContainer $meta;
}
