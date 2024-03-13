<?php

namespace ArtisanElevated\Pesapal\Requests;

use ArtisanElevated\Pesapal\Enums\IpnType;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreatePesapalIpn extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public string $url,
        public IpnType $ipnType
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/api/URLSetup/RegisterIPN';
    }

    protected function defaultBody(): array
    {
        return [
            'url'                   => $this->url,
            'ipn_notification_type' => $this->ipnType->name,
        ];
    }
}
