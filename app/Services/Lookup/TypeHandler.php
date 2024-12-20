<?php

declare(strict_types=1);

namespace App\Services\Lookup;

use App\Enums\TypeEnum;
use Illuminate\Contracts\Container\Container;
use App\Exceptions\InvalidProvidedDataException;
use Illuminate\Contracts\Container\BindingResolutionException;

class TypeHandler
{
    protected array $handlers;

    /**
     * @param Container $container
     */
    public function __construct(protected Container $container)
    {
        $this->handlers = [
            TypeEnum::MINECRAFT->value => MinecraftService::class,
            TypeEnum::STEAM->value => SteamService::class,
            TypeEnum::XBL->value => XblService::class,
        ];
    }

    /**
     * @param string $type
     * @return TypeServiceAbstract
     * @throws InvalidProvidedDataException
     * @throws BindingResolutionException
     */
    public function getHandler(string $type): TypeServiceAbstract
    {
        if (!isset($this->handlers[$type])) {
            throw new InvalidProvidedDataException("Handler not found for type: {$type}");
        }

        // if it throws it should be handled by the Handler and monitoring tools e.g. sentry
        return $this->container->make($this->handlers[$type]);
    }
}
