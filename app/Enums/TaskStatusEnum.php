<?php

namespace App\Enums;

enum TaskStatusEnum: int
{
    case OVERDUE = -1;
    case PENDING = 0;
    case IN_PROGRESS = 1;
    case COMPLETED = 2;
}
