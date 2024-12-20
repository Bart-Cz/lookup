<?php declare(strict_types=1);

namespace App\Objects;

class LookupDtoOutput
{
    public function __construct(
        public string $id,
        public string $username,
        public string $avatar,
    ) {}

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'id' => $this->id,
            'avatar' => $this->avatar,
        ];
    }
}
