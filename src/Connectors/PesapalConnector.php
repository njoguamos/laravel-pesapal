<?php

namespace NjoguAmos\Pesapal\Connectors;

use NjoguAmos\Pesapal\Models\PesapalToken;
use Saloon\Http\Auth\TokenAuthenticator;

class PesapalConnector extends PesapalBaseConnector
{
    public ?string $token;

    public function __construct()
    {
        $this->token = PesapalToken::latest()->first()?->access_token;

        parent::__construct();
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }
}
