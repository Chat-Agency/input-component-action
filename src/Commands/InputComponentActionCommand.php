<?php

declare(strict_types=1);

namespace ChatAgency\InputComponentAction\Commands;

use Illuminate\Console\Command;

class InputComponentActionCommand extends Command
{
    public $signature = 'input-component-action';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
