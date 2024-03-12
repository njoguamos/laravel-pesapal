<?php

namespace ArtisanElevated\Pesapal\Connectors;

use Saloon\Http\Connector;

class PesapalConnector extends Connector
{
    public string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config(key: 'pesapal.base_url');
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
