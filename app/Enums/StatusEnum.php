<?php

namespace App\Enums;

enum StatusEnum: string
{
    case APPROVED  = 'approved';
    case PENDING   = 'pending';
    case REJECTED  = 'rejected';
    case CANCELLED = 'cancelled';

    case ACTIVE   = 'active';
    case INACTIVE = 'inactive';
}
