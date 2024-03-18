<?php

namespace NjoguAmos\Pesapal\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPesapalIpns extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/URLSetup/GetIpnList';
    }
}
