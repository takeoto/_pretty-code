<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Provider;

use Takeoto\PrettyCode\Contract\TransactionsProviderInterface;
use Takeoto\PrettyCode\Dictionary\Currency;
use Takeoto\PrettyCode\DTO\TransactionDTO;

class TransactionsFromFileProvider implements TransactionsProviderInterface
{
    public function __construct(private readonly string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException(sprintf('The transactions file "%s" does not exist.', $filePath));
        }
    }

    /**
     * @inheritDoc
     */
    public function getAll(): iterable
    {
        $fp = @fopen($this->filePath, 'r');

        if (!$fp) {
            return;
        }

        while ($row = fgets($fp)) {
            $parsed = @json_decode($row, true);
            $transactionDTO = $this->makeTransactionDTO($parsed);

            if ($transactionDTO === null) {
                continue;
            }

            yield $transactionDTO;
        }

        fclose($fp);
    }

    /**
     * @param mixed $parsedData
     * @return TransactionDTO|null
     */
    public function makeTransactionDTO(mixed $parsedData): ?TransactionDTO
    {
        switch (false) {
            case is_array($parsedData):
            case array_key_exists('bin', $parsedData):
            case array_key_exists('amount', $parsedData):
            case array_key_exists('currency', $parsedData):
            case ($binCode = filter_var($parsedData['bin'], FILTER_VALIDATE_INT)) !== false:
            case ($amount = filter_var($parsedData['amount'], FILTER_VALIDATE_FLOAT)) !== false:
            case is_string($parsedData['currency']):
            case ($currency = Currency::tryFrom($parsedData['currency'])) !== null:
                return null;
        }

        return new TransactionDTO($binCode, $amount, $currency);
    }
}
