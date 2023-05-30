<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Contract;

use Takeoto\PrettyCode\Dictionary\Currency;

interface CurrenciesProviderInterface
{
    public function getRate(Currency $currency): float;
}
