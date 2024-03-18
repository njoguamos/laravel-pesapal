<?php

namespace NjoguAmos\Pesapal\Requests;

use NjoguAmos\Pesapal\DTOs\PesapalAddressData;
use NjoguAmos\Pesapal\DTOs\PesapalOrderData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreatePesapalOrder extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public PesapalOrderData $orderData,
        public PesapalAddressData $billingAddress
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/api/Transactions/SubmitOrderRequest';
    }

    protected function defaultBody(): array
    {
        return [
            'id'               => $this->orderData->id,
            'currency'         => $this->orderData->currency->name,
            'amount'           => $this->orderData->amount,
            'description'      => $this->orderData->description,
            'callback_url'     => $this->orderData->callbackUrl,
            'notification_id'  => $this->orderData->notificationId,
            'branch'           => $this->orderData->branch,
            'cancellation_url' => $this->orderData->cancellationUrl,
            'redirect_mode'    => $this->orderData->redirectMode->name,
            'billing_address'  => [
                'phone_number'  => $this->billingAddress->phoneNumber,
                'email_address' => $this->billingAddress->emailAddress,
                'country_code'  => $this->billingAddress->countryCode?->name,
                'first_name'    => $this->billingAddress->firstName,
                'middle_name'   => $this->billingAddress->middleName,
                'last_name'     => $this->billingAddress->lastName,
                'line_1'        => $this->billingAddress->line1,
                'line_2'        => $this->billingAddress->line2,
                'city'          => $this->billingAddress->city,
                'state'         => $this->billingAddress->state,
                'postal_code'   => $this->billingAddress->postalCode,
                'zip_code'      => $this->billingAddress->zipCode,
            ]
        ];
    }
}
