<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\InvalidProvidedDataException;
use App\Exceptions\LookupApiException;
use App\Objects\LookupDtoOutput;

trait CommonLookupApiTrait
{
    /**
     * @param string|null $username
     * @param string|null $lookupId
     * @return LookupDtoOutput|null
     * @throws InvalidProvidedDataException
     * @throws LookupApiException
     */
    public function fetchDataFromApi(?string $username, ?string $lookupId): ?LookupDtoOutput
    {
        $url = $this->resolveApiUrl($username, $lookupId);

        if (!$url) {
            throw new InvalidProvidedDataException('Either "username" or "id" must be provided.');
        }

        $match = $this->lookupApi->request('GET', $url);

        if (!isset($match->username, $match->id, $match->meta?->avatar)) {
            throw new LookupApiException("Unexpected API response format.");
        }

        return new LookupDtoOutput(
            id: $match->id,
            username: $match->username,
            avatar: $match->meta->avatar
        );
    }
}
