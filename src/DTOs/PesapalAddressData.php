<?php

namespace NjoguAmos\Pesapal\DTOs;

use Illuminate\Validation\Rule;
use NjoguAmos\Pesapal\Enums\ISOCountryCode;
use Spatie\LaravelData\Dto;

class PesapalAddressData extends Dto
{
    public function __construct(
        public string $phoneNumber = "",
        public string $emailAddress = "",
        public ?ISOCountryCode $countryCode = null,
        public string $firstName = "",
        public string $middleName = "",
        public string $lastName = "",
        public string $line1 = "",
        public string $line2 = "",
        public string $city = "",
        public string $state = "",
        public string $postalCode = "",
        public string $zipCode = "",
    ) {
    }

    public static function rules(): array
    {
        // @see https://developer.pesapal.com/how-to-integrate/e-commerce/api-30-json/submitorderrequest
        return [
            'phoneNumber'  => ['string', 'required_without:emailAddress'],
            'emailAddress' => ['email', 'required_without:phoneNumber'],
            'countryCode'  => [Rule::enum(type: ISOCountryCode::class) ],
            'amount'       => ['string'],
            'firstName'    => ['string'],
            'middleName'   => ['string'],
            'lastName'     => ['string'],
            'line1'        => ['string'],
            'line2'        => ['string'],
            'city'         => ['string'],
            'state'        => ['string'],
            'postalCode'   => ['string'],
            'zipCode'      => ['string'],
        ];
    }
}
