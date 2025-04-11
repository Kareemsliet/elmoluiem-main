<?php

namespace App\Enums;

enum PaymentStatusEnums: string
{
    case PENDING = "pending";
    case SUCCESS = "success";
    case FAILED = "failed";
    case REFUNDED = "refunded";
    case CANCELLED = "cancelled";
}
