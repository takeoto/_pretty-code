<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Contract;

use Takeoto\PrettyCode\DTO\TransactionDTO;

interface TransactionsProviderInterface
{
    /**
     * @return iterable<int,TransactionDTO>
     */
    public function getAll(): iterable;
}
