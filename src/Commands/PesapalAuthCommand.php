<?php

namespace ArtisanElevated\Pesapal\Commands;

use ArtisanElevated\Pesapal\Models\PesapalToken;
use ArtisanElevated\Pesapal\Pesapal;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class PesapalAuthCommand extends Command
{
    public $signature = 'pesapal:auth';

    public $description = 'Get a fresh access token from Pesapal and save to database.';

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \JsonException
     */
    public function handle(): int
    {
        $response = Pesapal::getAccessToken();

        if($response->ok()) {
            PesapalToken::create([
                'access_token' => $response->json(key: 'token'),
                // The 'expiryDate' is in UTC timezone, so it is first parsed with the UTC timezone.
                // Then, the timezone is converted to the application's timezone using the 'tz' method.
                'expires_at' => Carbon::parse(time: $response->json(key: 'expiryDate'), tz: 'UTC')->tz(config(key: 'app.timezone'))
            ]);

            $this->comment(string: 'A fresh access token has been retrieved and saved to the database.');

            return self::SUCCESS;
        }

        $this->error(string: 'Failed to get access token from Pesapal. Please try again.');

        return self::FAILURE;
    }
}
