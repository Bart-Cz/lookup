<?php

declare(strict_types=1);

namespace App\Services\LookupApi;

use App\Exceptions\InvalidProvidedDataException;
use App\Interfaces\LookupClientApiInterface;
use App\Interfaces\LookupApiInterface;
use App\Traits\CommonLookupApiTrait;

class SteamApi implements LookupApiInterface
{
    use CommonLookupApiTrait;

    protected string $steamUrlForId;

    /**
     * @param LookupClientApiInterface $lookupApi
     */
    public function __construct(protected LookupClientApiInterface $lookupApi)
    {
        $this->steamUrlForId = config('lookup.steam_url_for_id');
    }

    /**
     * @param string|null $username
     * @param string|null $lookupId
     * @return string|null
     * @throws InvalidProvidedDataException
     */
    public function resolveApiUrl(?string $username, ?string $lookupId): ?string
    {
        if ($username && !$lookupId) {
            throw new InvalidProvidedDataException('Steam only supports IDs');
        }

        // just in case
        if (!$lookupId) {
            throw new InvalidProvidedDataException("ID is required for lookup.");
        }

        return  $this->steamUrlForId . $lookupId;
    }
}
