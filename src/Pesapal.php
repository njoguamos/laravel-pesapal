<?php

namespace ArtisanElevated\Pesapal;

use ArtisanElevated\Pesapal\Connectors\PesapalConnector;
use ArtisanElevated\Pesapal\Requests\GetPesapalAccessToken;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;

class Pesapal
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public static function getAccessToken(): Response
    {
        $connector = new PesapalConnector();
        $request = new GetPesapalAccessToken();

        return $connector->send($request);
    }
}
