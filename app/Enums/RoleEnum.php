<?php

namespace App\Enums;

enum RoleEnum : string
{
    case EMPLOYEE = 'employee';

    // case HR = 'hr'; - removed because HR and admin has the same functionality

    case ADMIN = 'admin';
}
