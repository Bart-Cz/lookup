<?php

declare(strict_types=1);

namespace App\Services\Lookup;

use App\Interfaces\LookupApiInterface;
use Illuminate\Support\Facades\Cache;
use App\Objects\LookupDtoOutput;
use App\Objects\LookupDto;

class TypeServiceAbstract
{
    public function __construct(public LookupApiInterface $lookupApi)
    {
    }

    public function handle(LookupDto $lookupDto): LookupDtoOutput
    {
        $username = $lookupDto->getUsername();
        $lookupId = $lookupDto->getId();

        $cacheKey = $lookupDto->getCacheKey();

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($username, $lookupId) {
            return $this->lookupApi->fetchDataFromApi($username, $lookupId);
        });
    }
}
