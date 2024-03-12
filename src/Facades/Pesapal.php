<?php

namespace ArtisanElevated\Pesapal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ArtisanElevated\Pesapal\Pesapal
 */
class Pesapal extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ArtisanElevated\Pesapal\Pesapal::class;
    }
}
