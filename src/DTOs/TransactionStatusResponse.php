<?php

namespace NjoguAmos\Pesapal\DTOs;

use Spatie\LaravelData\Dto;

class TransactionStatusResponse extends Dto
{
    public function __construct(
        public float $amount,
        public string $created_date,
        public string $payment_status_description,
        public string $call_back_url,
        public string $message,
        public string $merchant_reference,
        public mixed $currency,
        public TransactionError $error,
        public int $status_code,
        public int $status,
        public string $payment_method = "",
        public ?string $description = null,
        public string $confirmation_code = "",
        public string $payment_account = "",
        public string $payment_status_code = "",
    ) {
    }
}
