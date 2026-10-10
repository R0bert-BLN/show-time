<?php

namespace App\Enum;

enum IssuedTicketStatus: string
{
    case USED = 'used';
    case ACTIVE = 'active';
}
