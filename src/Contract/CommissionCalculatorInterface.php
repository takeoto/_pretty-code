<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Contract;

use Takeoto\PrettyCode\DTO\TransactionDTO;

interface CommissionCalculatorInterface
{
    public function calculate(TransactionDTO $transaction): float;
}