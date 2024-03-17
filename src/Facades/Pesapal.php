<?php

namespace NjoguAmos\Pesapal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NjoguAmos\Pesapal\Pesapal
 */
class Pesapal extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NjoguAmos\Pesapal\Pesapal::class;
    }
}
