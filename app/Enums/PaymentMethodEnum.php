<?php

namespace App\Enums;

enum PaymentMethodEnum : string
{
    case BANK_TRANSFER = 'bank_transfer';
    case CHECK = 'check';
    case CASH = 'cash';
}
