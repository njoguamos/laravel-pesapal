<?php

use ArtisanElevated\Pesapal\Models\PesapalToken;

it(description: 'can encrypts access_token when saving to database', closure: function () {
    $token = PesapalToken::factory()->create();

    $dbToken = DB::table('pesapal_tokens')->first();

    expect(value: $token->access_token)->not->toBe(expected: $dbToken->access_token);
});
