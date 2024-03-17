<?php

namespace NjoguAmos\Pesapal\Connectors;

use Saloon\Http\Connector;

class PesapalBaseConnector extends Connector
{
    public string $baseUrl;

    public function __construct()
    {
        if (config(key: 'pesapal.pesapal_live')) {
            $this->baseUrl = config(key: 'pesapal.base_url.live');
        } else {
            $this->baseUrl = config(key: 'pesapal.base_url.staging');
        }
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ];
    }
}
