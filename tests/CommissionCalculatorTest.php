<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Takeoto\PrettyCode\Dictionary\Country;
use Takeoto\PrettyCode\Dictionary\Currency;
use Takeoto\PrettyCode\DTO\BinDTO;
use Takeoto\PrettyCode\CommissionCalculator;
use Takeoto\PrettyCode\Contract\BinProviderInterface;
use Takeoto\PrettyCode\Contract\CurrenciesProviderInterface;
use Takeoto\PrettyCode\DTO\TransactionDTO;

#[CoversClass(CommissionCalculator::class)]
final class CommissionCalculatorTest extends TestCase
{
    public static function calculationProvider(): array
    {
        return [
            'With euro currency and Europe country' => [
                'transaction' => [
                    'amount' => 100,
                    'currency' => [
                        'rate' => 0.0,
                        'code' => Currency::EURO,
                    ],
                    'bin' => [
                        'code' => 1,
                        'country' => Country::AUSTRIA,
                    ],
                ],
                'commission' => 1.0,
            ],
            'Ignores the rate if currency is euro and Europe country' => [
                'transaction' => [
                    'amount' => 100,
                    'currency' => [
                        'rate' => 2.0,
                        'code' => Currency::EURO,
                    ],
                    'bin' => [
                        'code' => 1,
                        'country' => Country::AUSTRIA,
                    ],
                ],
                'commission' => 1.0,
            ],
            'Calculates by the currency rate if currency is not euro and Europe country' => [
                'transaction' => [
                    'amount' => 100,
                    'currency' => [
                        'rate' => 2.0,
                        'code' => Currency::JAPANESE_YEN,
                    ],
                    'bin' => [
                        'code' => 1,
                        'country' => Country::AUSTRIA,
                    ],
                ],
                'commission' => 0.5,
            ],
            'With euro currency and not Europe country' => [
                'transaction' => [
                    'amount' => 100,
                    'currency' => [
                        'rate' => 0.0,
                        'code' => Currency::EURO,
                    ],
                    'bin' => [
                        'code' => 1,
                        'country' => Country::AFGHANISTAN,
                    ],
                ],
                'commission' => 2.0,
            ],
            'Ignores the rate if currency is euro and not Europe country' => [
                'transaction' => [
                    'amount' => 100,
                    'currency' => [
                        'rate' => 2.0,
                        'code' => Currency::EURO,
                    ],
                    'bin' => [
                        'code' => 1,
                        'country' => Country::AFGHANISTAN,
                    ],
                ],
                'commission' => 2.0,
            ],
            'Calculates by the currency rate if currency is not euro and not Europe country' => [
                'transaction' => [
                    'amount' => 100,
                    'currency' => [
                        'rate' => 2.0,
                        'code' => Currency::JAPANESE_YEN,
                    ],
                    'bin' => [
                        'code' => 1,
                        'country' => Country::AFGHANISTAN,
                    ],
                ],
                'commission' => 1.0,
            ],
            'Round up commission' => [
                'transaction' => [
                    'amount' => 100,
                    'currency' => [
                        'rate' => 2.123,
                        'code' => Currency::JAPANESE_YEN,
                    ],
                    'bin' => [
                        'code' => 1,
                        'country' => Country::AFGHANISTAN,
                    ],
                ],
                'commission' => 0.95,
            ],
        ];
    }

    #[DataProvider('calculationProvider')]
    public function testCalculation(array $transaction, float $commission)
    {
        $transactionDTO = new TransactionDTO(
            $binCode = $transaction['bin']['code'],
            $transaction['amount'],
            $currency = $transaction['currency']['code'],
        );
        $currenciesProviderMock = self::createMock(CurrenciesProviderInterface::class);
        $currenciesProviderMock
            ->method('getRate')
            ->with($currency)
            ->willReturn($transaction['currency']['rate']);
        $binProviderMock = self::createMock(BinProviderInterface::class);
        $binProviderMock
            ->expects(self::once())
            ->method('getByCode')
            ->with($binCode)
            ->willReturn(new BinDTO(
                $binCode,
                $transaction['bin']['country']
            ));
        $calculator = new CommissionCalculator($currenciesProviderMock, $binProviderMock);
        self::assertEquals($commission, $calculator->calculate($transactionDTO));
    }
}