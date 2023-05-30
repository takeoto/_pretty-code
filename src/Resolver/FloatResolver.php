<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Resolver;

final class FloatResolver
{
    # As an improvement, add ceiling of commissions by cents. For example, 0.46180... should become 0.47.
    public static function roundUp(float $number, int $precision): float
    {
        $multiplier = pow(10, abs($precision));

        return $number < 0 ? ceil($number / $multiplier) * $multiplier : ceil($number * $multiplier) / $multiplier;
    }
}
