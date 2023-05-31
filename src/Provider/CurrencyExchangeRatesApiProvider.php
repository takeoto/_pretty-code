<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Provider;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Takeoto\PrettyCode\Contract\CurrenciesProviderInterface;
use Takeoto\PrettyCode\Dictionary\Currency;

class CurrencyExchangeRatesApiProvider implements CurrenciesProviderInterface
{
    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly string $uri,
        private readonly string $accessToken,
    ) {
    }

    public function getRate(string $currency): float
    {
        $response = $this->httpClient->request('GET', $this->uri, [
            RequestOptions::QUERY => [
                'access_key' => $this->accessToken,
            ],
        ]);

        if (($code = $response->getStatusCode()) !== 200) {
            throw new \RuntimeException(sprintf('The uri "%s" response with %d status code', $this->uri, $code));
        }

        $responseBody = $response->getBody()->getContents();
        $responseBody = @json_decode($responseBody, true);

        switch (false) {
            case is_array($responseBody):
            case array_key_exists('rates', $responseBody):
            case is_array($responseBody['rates']):
            case array_key_exists($currency, $responseBody['rates']):
            case ($rate = filter_var($responseBody['rates'][$currency], FILTER_VALIDATE_FLOAT)) !== false:
                return 0.0;
        }

        return $rate;
    }
}
