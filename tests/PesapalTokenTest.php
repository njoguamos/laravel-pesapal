<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use NjoguAmos\Pesapal\Models\PesapalToken;

it(description: 'can save long token to the database', closure: function () {
    $token = PesapalToken::create([
        'access_token' => Str::random(length: 2048),
        'expires_at'   => now()->addMinutes(5)
    ]);

    expect(value: $token->fresh()->exists())->toBeTrue();
});
