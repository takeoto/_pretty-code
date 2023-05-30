<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Dictionary;

enum Currency: string
{
    case EURO = 'EUR';
    case UNITED_STATES_DOLLAR = 'USD';
    case JAPANESE_YEN = 'JPY';
    case STERLING = 'GBP';
    # Other currencies
}
