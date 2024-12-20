<?php

declare(strict_types=1);

namespace App\Interfaces;

interface LookupClientApiInterface
{
    /**
     * @param string $method
     * @param string $endpoint
     * @return object|null
     */
    public function request(string $method, string $endpoint): ?object;
}
