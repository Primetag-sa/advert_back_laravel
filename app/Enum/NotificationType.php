<?php

namespace App\Enum;

enum NotificationType: string
{
    case SYSTEM = 'system';
    case AGENCY = 'agency';
    case USER = 'user';
}
