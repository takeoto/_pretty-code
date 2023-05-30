<?php

include_once './vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Takeoto\PrettyCode\Provider\BinListProvider;
use Takeoto\PrettyCode\CommissionCalculator;
use Takeoto\PrettyCode\Provider\CurrencyExchangeRatesApiProvider;
use Takeoto\PrettyCode\Provider\TransactionsFromFileProvider;

$filePath = $argv[1] ?? throw new \InvalidArgumentException('The first argument should be a transactions file path.');
$accessToken = $argv[2] ?? throw new \InvalidArgumentException('You should provide an access token.');

$httpClient = new Client([RequestOptions::TIMEOUT => 30.0]);
$calculator = new CommissionCalculator(
    new CurrencyExchangeRatesApiProvider($httpClient, 'http://api.exchangeratesapi.io/latest', $accessToken),
    new BinListProvider($httpClient, 'https://lookup.binlist.net'),
);
$transactionsProvider = new TransactionsFromFileProvider($filePath);

foreach ($transactionsProvider->getAll() as $transaction) {
    echo $calculator->calculate($transaction), PHP_EOL;
}

exit(0);
