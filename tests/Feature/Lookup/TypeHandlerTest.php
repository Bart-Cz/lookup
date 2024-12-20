<?php

namespace Tests\Feature\Lookup;

use App\Exceptions\InvalidProvidedDataException;
use App\Services\Lookup\SteamService;
use App\Services\Lookup\TypeHandler;
use App\Objects\LookupDto;
use Tests\TestCase;

class TypeHandlerTest extends TestCase
{
    public function test_type_handler_works_as_expected()
    {
        $lookupDto = new LookupDto('steam', '111', 'goodusername');

        $typeHandler = app(TypeHandler::class);
        $lookupHandler = $typeHandler->getHandler($lookupDto->getType());

        $this->assertInstanceOf(SteamService::class, $lookupHandler);
    }

    public function test_type_handler_throws_exception_when_unknown_type_is_given()
    {
        $lookupDto = new LookupDto('unknownservice', '111', 'goodusername');

        $typeHandler = app(TypeHandler::class);
        $this->expectException(InvalidProvidedDataException::class);

        $typeHandler->getHandler($lookupDto->getType());
    }
}
