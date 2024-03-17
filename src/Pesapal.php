<?php

namespace NjoguAmos\Pesapal;

use NjoguAmos\Pesapal\Connectors\PesapalBaseConnector;
use NjoguAmos\Pesapal\Connectors\PesapalConnector;
use NjoguAmos\Pesapal\Enums\IpnType;
use NjoguAmos\Pesapal\Models\PesapalIpn;
use NjoguAmos\Pesapal\Models\PesapalToken;
use NjoguAmos\Pesapal\Requests\CreatePesapalIpn;
use NjoguAmos\Pesapal\Requests\CreatePesapalToken;
use Carbon\Carbon;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class Pesapal
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public static function createToken(): ?PesapalToken
    {
        $connector = new PesapalBaseConnector();
        $request = new CreatePesapalToken();

        $response = $connector->send($request);

        if ($response->ok()) {
            return PesapalToken::create([
                'access_token' => $response->json(key: 'token'),
                // The 'expiryDate' is in UTC timezone, so it is first parsed with the UTC timezone.
                // Then, the timezone is converted to the application's timezone using the 'tz' method.
                'expires_at' => Carbon::parse(time: $response->json(key: 'expiryDate'), tz: 'UTC')->tz(config(key: 'app.timezone'))
            ]);
        }

        return null;
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public static function createIpn(string $url, IpnType $ipnType): ?PesapalIpn
    {
        $connector = new PesapalConnector();
        $request = new CreatePesapalIpn(url: $url, ipnType: $ipnType);

        $response = $connector->send($request);

        if ($response->ok()) {
            return PesapalIpn::updateOrCreate(
                attributes: [
                    'url' => $response->json(key: 'url'),
                ],
                values: [
                    'ipn_id' => $response->json(key: 'ipn_id'),
                    'url'    => $response->json(key: 'url'),
                    'type'   => $ipnType,
                    'status' => $response->json(key: 'ipn_status'),
                    // The 'created_date' is in UTC timezone, so it is first parsed with the UTC timezone.
                    // Then, the timezone is converted to the application's timezone using the 'tz' method.
                    'created_at' => Carbon::parse(time: $response->json(key: 'created_date'), tz: 'UTC')->tz(config(key: 'app.timezone'))
                ]
            );
        }

        return null;
    }
}
