<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Provider;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Takeoto\PrettyCode\Contract\BinProviderInterface;
use Takeoto\PrettyCode\Dictionary\Country;
use Takeoto\PrettyCode\DTO\BinDTO;

class BinListProvider implements BinProviderInterface
{
    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly string $uri,
    ) {
    }

    public function getByCode(int $code): ?BinDTO
    {
        $response = $this->httpClient->request('GET', $uri = rtrim($this->uri, '/') . '/' . $code, [
            RequestOptions::ALLOW_REDIRECTS => true,
        ]);

        if (($code = $response->getStatusCode()) !== 200) {
            throw new \RuntimeException(sprintf('The uri "%s" response with %d status code', $uri, $code));
        }

        $responseBody = $response->getBody()->getContents();
        $responseBody = @json_decode($responseBody, true);

        switch (false) {
            case is_array($responseBody):
            case array_key_exists('country', $responseBody):
            case is_array($responseBody['country']):
            case array_key_exists('alpha2', $responseBody['country']):
            case is_string($responseBody['country']['alpha2']):
            case ($country = Country::tryFrom($responseBody['country']['alpha2'])) !== null:
                return null;
        }

        return new BinDTO($code, $country);
    }
}