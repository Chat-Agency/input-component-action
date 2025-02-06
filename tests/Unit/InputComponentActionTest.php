<?php

use Tests\Collections;
use Chatagency\CrudAssistant\InputCollection;
use ChatAgency\BackendComponents\Enums\ComponentEnum;
use Chatagency\CrudAssistant\DataContainer;
use ChatAgency\InputComponentAction\Enums\FormInputTypes;
use ChatAgency\InputComponentAction\InputComponentAction;

test('the action returns a data container object', function () {
    
    $action = new InputComponentAction();
    $crud = Collections::simple();

    $output = $crud->execute($action);

    expect($output)
        ->toBeInstanceOf(DataContainer::class);

    
});

test('the data container has inputs and meta', function(){

    $action = new InputComponentAction();
    $crud = Collections::simple();

    $output = $crud->execute($action);

    expect($output->get('inputs'))->toBeInstanceOf(DataContainer::class);
    expect($output->get('meta'))->toBeInstanceOf(DataContainer::class);

});