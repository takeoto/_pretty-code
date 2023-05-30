<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\DTO;

use Takeoto\PrettyCode\Dictionary\Country;

class BinDTO
{
    public function __construct(
        public readonly int $code,
        public readonly Country $country,
    ) {
    }
}