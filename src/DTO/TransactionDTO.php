<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\DTO;

class TransactionDTO
{
    public function __construct(
        public readonly int $binCode,
        public readonly float $amount,
        public readonly ?string $currency,
    ) {
    }
}
