<?php

namespace App\Enum;

enum CartStatus: string
{
    case PROCESSING = 'processing';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
}
