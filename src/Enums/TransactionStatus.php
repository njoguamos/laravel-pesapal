<?php

namespace NjoguAmos\Pesapal\Enums;

enum TransactionStatus: int
{
    case COMPLETE = 200;
    case INCOMPLETE = 500;
}
