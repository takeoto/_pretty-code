<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode;

use Takeoto\PrettyCode\Contract\BinProviderInterface;
use Takeoto\PrettyCode\Contract\CommissionCalculatorInterface;
use Takeoto\PrettyCode\Contract\CurrenciesProviderInterface;
use Takeoto\PrettyCode\Dictionary\Continent;
use Takeoto\PrettyCode\Dictionary\Country;
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

    /**
     * @inheritDoc
     */
    public function calculate(TransactionDTO $transaction): float
    {
        $bin = $this->binProvider->getByCode($transaction->binCode);
        # in the old code if $bin === null I should throw an error
        $continent = $bin ? Country::getContinent($bin->country) : null;
        $locationCoefficient = $continent === Continent::EUROPE ? 0.01 : 0.02;
        $currency = $transaction->currency;
        $amntFixed = $transaction->amount;

        if ($currency !== Currency::EURO) {
            $rate = $currency ? $this->currenciesProvider->getRate($currency) : 0;
            $amntFixed = $rate > 0 ? $amntFixed / $rate : $amntFixed;
        }

        return FloatResolver::roundUp($amntFixed * $locationCoefficient, 2);
    }
}
