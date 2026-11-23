<?php

namespace App\Enums;

enum UnitType: string
{
    case Outdoor = 'outdoor';
    case Indoor = 'indoor';
    case Controller = 'controller';
    case Accessory = 'accessory';
}
