<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\InvalidProvidedDataException;
use App\Http\Requests\Lookup\LookupRequest;
use App\Exceptions\LookupApiException;
use App\Services\Lookup\TypeHandler;
use Illuminate\Http\JsonResponse;
use App\Objects\LookupDto;

/**
 * Class LookupController
 *
 * @package App\Http\Controllers
 */
class LookupController extends Controller
{
    public function __construct(protected TypeHandler $typeHandler)
    {
    }

    public function lookup(LookUpRequest $request): JsonResponse
    {
        $lookupDto = LookupDto::fromRequest($request);

        try {
            $lookupHandler = $this->typeHandler->getHandler($lookupDto->getType());
            $lookupDtoOutput = $lookupHandler->handle($lookupDto);

            return response()->json($lookupDtoOutput->toArray());
            // handling of custom exceptions created for lookup
            // if there is some other exception, it will be caught by Handler
        } catch (InvalidProvidedDataException|LookupApiException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?? 500);
        }
    }
}
