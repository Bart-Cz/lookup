<?php

declare(strict_types=1);

namespace App\Services\LookupApi;

use App\Exceptions\InvalidProvidedDataException;
use App\Interfaces\LookupClientApiInterface;
use App\Exceptions\LookupApiException;
use App\Interfaces\LookupApiInterface;
use App\Objects\LookupDtoOutput;

class MinecraftApi implements LookupApiInterface
{
    protected string $minecraftUrlForId;
    protected string $minecraftUrlForUsername;
    public function __construct(protected LookupClientApiInterface $lookupApi)
    {
        $this->minecraftUrlForId = config('lookup.minecraft_url_for_id');
        $this->minecraftUrlForUsername = config('lookup.minecraft_url_for_username');
    }

    public function fetchDataFromApi(?string $username, ?string $lookupId): ?LookupDtoOutput
    {
        $url = $this->resolveApiUrl($username, $lookupId);

        if (!$url) {
            throw new InvalidProvidedDataException('Either "username" or "id" must be provided.');
        }

        $match = $this->lookupApi->request('GET', $url);

        if (!isset($match->name, $match->id)) {
            throw new LookupApiException("Unexpected API response format.");
        }

        return new LookupDtoOutput(
            id: $match->id,
            username: $match->name,
            avatar: config('lookup.minecraft_avatar_base_url') . $match->id
        );
    }

    public function resolveApiUrl(?string $username, ?string $lookupId): ?string
    {
        // it seems that id has a precedence, hence if both id and username provided it takes id
        if ($lookupId) {
            return $this->minecraftUrlForId . $lookupId;
        }

        if ($username) {
            return $this->minecraftUrlForUsername . $username;
        }

        // there is a validation for at least id or username, but in case something fails on the way
        return null;
    }
}
