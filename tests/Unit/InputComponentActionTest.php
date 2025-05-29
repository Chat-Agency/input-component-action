<?php

declare(strict_types=1);

use Chatagency\CrudAssistant\DataContainer;
use ChatAgency\InputComponentAction\Containers\InputComponentOutput;
use ChatAgency\InputComponentAction\InputComponentAction;
use Tests\Collections;

test('the action returns a data container object', function (): void {

    $action = new InputComponentAction;
    $crud = Collections::simple();

    $output = $crud->execute($action);

    expect($output)
        ->toBeInstanceOf(InputComponentOutput::class);

});

test('the data container has inputs and meta', function (): void {

    $action = new InputComponentAction;
    $crud = Collections::simple();

    $output = $crud->execute($action);

    expect($output->inputs)
        ->toBeInstanceOf(DataContainer::class);
    expect($output->meta)
        ->toBeInstanceOf(DataContainer::class);

});
