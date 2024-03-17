<?php

namespace NjoguAmos\Pesapal\Database\Factories;

use NjoguAmos\Pesapal\Models\PesapalToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesapalTokenFactory extends Factory
{
    protected $model = PesapalToken::class;

    public function definition(): array
    {
        return [
            'access_token' => $this->faker->sha256,
            'expires_at'   => now()->addMinutes(5),
        ];
    }
}
