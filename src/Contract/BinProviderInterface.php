<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Contract;

use Takeoto\PrettyCode\DTO\BinDTO;

interface BinProviderInterface
{
    /**
     * @param int $code
     * @return BinDTO|null
     * @throws \Throwable
     */
    public function getByCode(int $code): ?BinDTO;
}