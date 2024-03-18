<?php

namespace NjoguAmos\Pesapal\DTOs;

use Illuminate\Validation\Rule;
use NjoguAmos\Pesapal\Enums\ISOCurrencyCode;
use NjoguAmos\Pesapal\Enums\RedirectMode;
use Spatie\LaravelData\Dto;

class PesapalOrderData extends Dto
{
    public function __construct(
        public string $id,
        public ISOCurrencyCode $currency,
        public float $amount,
        public string $description,
        public string $callbackUrl,
        public string $notificationId,
        public string $cancellationUrl = "",
        public RedirectMode $redirectMode = RedirectMode::TOP_WINDOW,
        public string $branch = "",
    ) {
    }

    public static function rules(): array
    {
        // @see https://developer.pesapal.com/how-to-integrate/e-commerce/api-30-json/submitorderrequest
        return [
            'id'              => ['required', 'max:50'],
            'currency'        => ['required', Rule::enum(type: ISOCurrencyCode::class) ],
            'amount'          => ['required', 'decimal:0,2' ],
            'description'     => ['required', 'max:100' ],
            'callbackUrl'     => ['required', 'string' ],
            'notificationId'  => ['required', 'string', "exists:pesapal_ipns,ipn_id" ],
            'branch'          => ['string'],
            'cancellationUrl' => ['string'],
            'redirectMode'    => [ Rule::enum(type: RedirectMode::class) ],
        ];
    }
}
