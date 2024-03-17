<?php

use NjoguAmos\Pesapal\Models\PesapalToken;

it(description: 'can get access token from pesapal and save to database', closure: function () {
    $this->artisan(command: 'pesapal:auth')
        ->expectsOutput(output: 'A fresh access token has been retrieved and saved to the database.')
        ->assertExitCode(exitCode: 0);

    expect(PesapalToken::count())->toBe(1);
});
