<?php

namespace NjoguAmos\Pesapal\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPesapalTransactionStatus extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $orderTrackingId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/api/Transactions/GetTransactionStatus';
    }

    protected function defaultQuery(): array
    {
        return [
            'orderTrackingId' => $this->orderTrackingId
        ];
    }
}
