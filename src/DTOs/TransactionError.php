<?php

namespace NjoguAmos\Pesapal\DTOs;

use Spatie\LaravelData\Dto;

class TransactionError extends Dto
{
    public function __construct(
        public ?string $error_type = null,
        public ?string $code = null,
        public ?string $message = null,
        public ?string $call_back_url = null,
    ) {
    }
}
