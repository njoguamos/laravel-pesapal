<?php

use Illuminate\Validation\ValidationException;
use NjoguAmos\Pesapal\DTOs\PesapalOrderData;

it('requires id', function () {
    PesapalOrderData::validate([]);
})->throws(ValidationException::class, 'The id field is required.');

it('requires currency', function () {
    PesapalOrderData::validate([
        'id' => fake()->uuid()
    ]);
})->throws(ValidationException::class, 'The currency field is required.');

it('requires a valid currency', function () {
    PesapalOrderData::validate([
        'id'       => fake()->uuid(),
        'currency' => 'UNKNOWN'
    ]);
})->throws(ValidationException::class, 'The selected currency is invalid.');

todo('complete all validation tests');
