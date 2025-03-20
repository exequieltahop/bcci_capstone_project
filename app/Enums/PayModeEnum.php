<?php

namespace App\Enums;

enum PayModeEnum : string
{
    case MONTHLY = 'monthly';
    case WEEKLY = 'weekly';
    case SEMIMONTHLY = 'semi-monthly';
}
