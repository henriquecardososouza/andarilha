<?php

namespace App\Enums;

enum QuotationTypesEnum: int
{
    case PENDING = 0;
    case IN_CONTACT = 1;
    case NOT_AVAILABLE = 2;
    case QUOTE_FINISHED = 3;
    case OFFER_ACCEPTED = 4;
    case TRIP_FINALIZED = 5;
}
