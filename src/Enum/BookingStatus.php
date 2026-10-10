<?php

namespace App\Enum;

enum BookingStatus: string
{
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case PENDING = 'pending';
}
