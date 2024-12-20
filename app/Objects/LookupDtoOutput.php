<?php

declare(strict_types=1);

namespace App\Objects;

class LookupDtoOutput
{
    /**
     * @param string $id
     * @param string $username
     * @param string $avatar
     */
    public function __construct(
        public string $id,
        public string $username,
        public string $avatar,
    ) {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'id' => $this->id,
            'avatar' => $this->avatar,
        ];
    }
}
