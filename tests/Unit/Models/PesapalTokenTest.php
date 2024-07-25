<?php

use Illuminate\Support\Facades\DB;
use NjoguAmos\Pesapal\Models\PesapalToken;

use function Pest\Laravel\artisan;

it(description: 'can encrypts access_token when saving to database', closure: function () {
    $token = PesapalToken::factory()->create();

    $dbToken = DB::table('pesapal_tokens')->first();

    expect(value: $token->access_token)->not->toBe(expected: $dbToken->access_token);
});

it(description: 'can prune expired tokens', closure: function () {
    $expiredOtp = PesapalToken::factory()->expired()->create();
    $validOtp = PesapalToken::factory()->create();

    expect(value: PesapalToken::count())->toBe(expected: 2);

    artisan(command: 'model:prune', parameters: ['--model' => PesapalToken::class]);

    expect(value: PesapalToken::count())->toBe(expected: 1)
        ->and(value: $expiredOtp->fresh()?->exists())->toBeNull()
        ->and(value: $validOtp->fresh()->exists())->toBeTrue();
});
