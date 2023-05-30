<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode;

use Takeoto\PrettyCode\Contract\BinProviderInterface;
use Takeoto\PrettyCode\Contract\CommissionCalculatorInterface;
use Takeoto\PrettyCode\Contract\CurrenciesProviderInterface;
use Takeoto\PrettyCode\Dictionary\Continent;
use Takeoto\PrettyCode\Dictionary\Currency;
use Takeoto\PrettyCode\DTO\TransactionDTO;
use Takeoto\PrettyCode\Resolver\FloatResolver;

class CommissionCalculator implements CommissionCalculatorInterface
{
    public function __construct(
        private readonly CurrenciesProviderInterface $currenciesProvider,
        private readonly BinProviderInterface $binProvider,
    ) {
    }

    public function calculate(TransactionDTO $transaction): float
    {
        $currency = $transaction->currency;
        $bin = $this->binProvider->getByCode($transaction->binCode);
        $locationCoefficient = $bin?->country->getContinent() === Continent::EUROPE ? 0.01 : 0.02;
        $amntFixed = $currency === Currency::EURO
            ? $transaction->amount
            : $transaction->amount / $this->currenciesProvider->getRate($currency);

        return FloatResolver::roundUp($amntFixed * $locationCoefficient, 2);
    }
}