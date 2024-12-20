<?php declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\LookupDtoOutput;

interface LookupApiInterface
{
    public function fetchDataFromApi(?string $username, ?string $lookupId): ?LookupDtoOutput;

    public function resolveApiUrl(?string $username, ?string $lookupId): ?string;
}
