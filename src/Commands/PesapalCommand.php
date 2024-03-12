<?php

namespace ArtisanElevated\Pesapal\Commands;

use Illuminate\Console\Command;

class PesapalCommand extends Command
{
    public $signature = 'laravel-pesapal';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment(string: 'All done');

        return self::SUCCESS;
    }
}
