<?php

namespace ArtisanElevated\Pesapal\Database\Factories;

use ArtisanElevated\Pesapal\Enums\IpnType;
use ArtisanElevated\Pesapal\Models\PesapalIpn;
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
