<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InputComponentActionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('input-component-action');
        // ->hasConfigFile()
        // ->hasViews()
        // ->hasMigration('create_input_component_action_table')
    }
}
