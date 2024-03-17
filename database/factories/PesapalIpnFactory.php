<?php

namespace NjoguAmos\Pesapal\Database\Factories;

use NjoguAmos\Pesapal\Enums\IpnType;
use NjoguAmos\Pesapal\Models\PesapalIpn;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesapalIpnFactory extends Factory
{
    protected $model = PesapalIpn::class;

    public function definition(): array
    {
        return [
            'url'  => $this->faker->url,
            'type' => IpnType::GET,
        ];
    }
}
