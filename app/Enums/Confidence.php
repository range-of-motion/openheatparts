<?php

namespace App\Enums;

enum Confidence: string
{
    case Documented = 'documented';
    case Community = 'community';
    case Unverified = 'unverified';
}
