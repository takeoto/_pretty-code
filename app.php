<?php

include_once './vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Takeoto\PrettyCode\Provider\BinListProvider;
use Takeoto\PrettyCode\CommissionCalculator;
use Takeoto\PrettyCode\Provider\CurrencyExchangeRatesApiProvider;
use Takeoto\PrettyCode\Provider\TransactionsFromFileProvider;

$filePath = $argv[1] ?? throw new \InvalidArgumentException('The first argument should be a transactions file path.');
$httpClient = new Client([RequestOptions::TIMEOUT => 30.0]);
$calculator = new CommissionCalculator(
    new CurrencyExchangeRatesApiProvider($httpClient, 'http://api.exchangeratesapi.io/latest', 'd76d0de30cccf8b7398818661dbeaa7a'),
    new BinListProvider($httpClient, 'https://lookup.binlist.net'),
);
$transactionsProvider = new TransactionsFromFileProvider($filePath);

foreach ($transactionsProvider->getAll() as $transaction) {
    echo $calculator->calculate($transaction), PHP_EOL;
}

exit(0);