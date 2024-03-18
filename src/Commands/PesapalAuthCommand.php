<?php

namespace NjoguAmos\Pesapal\Commands;

use NjoguAmos\Pesapal\Models\PesapalToken;
use NjoguAmos\Pesapal\Pesapal;
use Illuminate\Console\Command;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class PesapalAuthCommand extends Command
{
    public $signature = 'pesapal:auth';

    public $description = 'Get a fresh access token from Pesapal and save to database.';

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function handle(): int
    {
        $token = Pesapal::createToken();

        if($token instanceof PesapalToken) {
            $this->info(string: 'A fresh access token has been retrieved and saved to the database.');

            return self::SUCCESS;
        }

        $this->error(string: 'Failed to get access token from Pesapal. Please try again.');

        return self::FAILURE;
    }
}
