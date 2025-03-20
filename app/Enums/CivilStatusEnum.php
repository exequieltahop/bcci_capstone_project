<?php

namespace App\Enums;

enum CivilStatusEnum : string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';
    case SEPARATED = 'separated';
    case ANNULLED = 'annulled';
    case CIVIL_PARTNERSHIP = 'civil partnership';
}
