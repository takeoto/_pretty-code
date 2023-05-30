<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Contract;

use Takeoto\PrettyCode\DTO\TransactionDTO;

interface CommissionCalculatorInterface
{
    /**
     * Calculates a commission by a transaction.
     *
     * @param TransactionDTO $transaction
     * @return float
     */
    public function calculate(TransactionDTO $transaction): float;
}
