<?php declare(strict_types=1);

namespace App\Interfaces;

interface LookupClientApiInterface
{
    public function request(string $method, string $endpoint, array $params = []): ?object;
}
