<?php

namespace App\Enums;

enum TableLocation: string
{
    case INSIDE = 'inside'; 
    case OUTSIDE = 'outside'; 
    case TERRACE = 'terrace';
    case VIP = 'vip';
}
