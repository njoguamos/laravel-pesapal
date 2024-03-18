<?php

namespace NjoguAmos\Pesapal\Requests;

use JsonException;
use NjoguAmos\Pesapal\DTOs\TransactionError;
use NjoguAmos\Pesapal\DTOs\TransactionStatusResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

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

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): TransactionStatusResponse
    {
        $data = $response->json();

        return new TransactionStatusResponse(
            amount: $data['amount'],
            created_date: $data['created_date'],
            payment_status_description: $data['payment_status_description'],
            call_back_url: $data['call_back_url'],
            message: $data['message'],
            merchant_reference: $data['merchant_reference'],
            currency: $data['currency'],
            error: $data['error'] ? new TransactionError(
                error_type: $data['error']['error_type'],
                code: $data['error']['code'],
                message: $data['error']['message'],
                call_back_url: $data['error']['call_back_url'],
            ) : null,
            status_code: $data['status_code'],
            status: $data['status'],
            payment_method: $data['payment_method'],
            description: $data['description'],
            confirmation_code: $data['confirmation_code'],
            payment_account: $data['payment_account']
        );
    }
}
