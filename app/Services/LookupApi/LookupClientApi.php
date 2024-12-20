<?php declare(strict_types=1);

namespace App\Services\LookupApi;

use App\Interfaces\LookupClientApiInterface;
use App\Exceptions\LookupApiException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LookupClientApi implements LookupClientApiInterface
{
    public function request(string $method, string $endpoint, array $params = []): ?object
    {
        // try/catch for not exposing anything when exception thrown by api call (e.g. Guzzle issue)
        try {
            $response = Http::{$method}($endpoint);
        } catch (\Exception $exception) {
            // potentially sentry or other monitoring tool
            Log::channel('api_calls')->error($exception->getMessage());

            throw new LookupApiException('API request failed.');
        }

        if ($response->successful()) {
            return json_decode($response->getBody()->getContents());
        }

        throw new LookupApiException('Failed to fetch data from the API.');
    }
}
