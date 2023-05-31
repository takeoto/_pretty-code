<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\DTO;

class BinDTO
{
    public function __construct(
        public readonly int $code,
        public readonly string $country,
    ) {
    }
}
