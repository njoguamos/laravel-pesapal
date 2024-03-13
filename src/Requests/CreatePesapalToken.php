<?php

namespace ArtisanElevated\Pesapal\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreatePesapalToken extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public string $consumerSecret;

    public string $consumerKey;

    public function __construct()
    {
        $this->consumerSecret = config(key: 'pesapal.consumer_secret');
        $this->consumerKey = config(key: 'pesapal.consumer_key');
    }

    public function resolveEndpoint(): string
    {
        return '/api/Auth/RequestToken';
    }

    protected function defaultBody(): array
    {
        return [
            'consumer_key'    => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
        ];
    }
}
