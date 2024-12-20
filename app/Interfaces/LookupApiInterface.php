<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\LookupDtoOutput;

interface LookupApiInterface
{
    /**
     * @param string|null $username
     * @param string|null $lookupId
     * @return LookupDtoOutput|null
     */
    public function fetchDataFromApi(?string $username, ?string $lookupId): ?LookupDtoOutput;

    /**
     * @param string|null $username
     * @param string|null $lookupId
     * @return string|null
     */
    public function resolveApiUrl(?string $username, ?string $lookupId): ?string;
}
