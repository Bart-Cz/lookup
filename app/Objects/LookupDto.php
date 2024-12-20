<?php declare(strict_types=1);

namespace App\Objects;

use App\Http\Requests\Lookup\LookupRequest;

class LookupDto
{
    public function __construct(protected string $type, protected ?string $id, protected ?string $username)
    {
    }

    public static function fromRequest(LookUpRequest $request): self
    {
        return new self(
            $request->type,
            $request->id ?? null,
            $request->username ?? null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            id: $data['id'] ?? null,
            username: $data['username'] ?? null,
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getCacheKey(): string
    {
        $idOrUsername = '';

        if(isset($this->id))
        {
            $idOrUsername .= '_id_' . $this->id;
        }

        if(isset($this->username))
        {
            $idOrUsername .= '_username_' . $this->username;
        }

        return "lookup_{$this->type}{$idOrUsername}";
    }
}
