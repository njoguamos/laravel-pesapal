<?php

namespace NjoguAmos\Pesapal\Enums;

enum TransactionStatusCode: int
{
    case INVALID = 0;
    case COMPLETED = 1;
    case FAILED = 2;
    case REVERSED = 3;
}
