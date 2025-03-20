<?php

namespace App\Enums;

enum GenderEnum : string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case NON_BINARY = 'non-binary';
    case GENDERQUEER = 'genderqueer';
    case GENDERFLUID = 'genderfluid';
    case AGENDER = 'agender';
    case BIGENDER = 'bigender';
    case TWO_SPIRIT = 'two-spirit';
    case TRANSGENDER = 'transgender';
    case CISGENDER = 'cisgender';
}
