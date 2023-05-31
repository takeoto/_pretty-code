<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Contract;

interface CurrenciesProviderInterface
{
    public function getRate(string $currency): float;
}
