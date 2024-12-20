<?php

namespace Tests\Unit\Lookup;

use App\Objects\LookupDto;
use PHPUnit\Framework\TestCase;

class LookupDtoTest extends TestCase
{
    public function test_dto()
    {
        $type = 'steam';
        $id = '123';
        $username = 'username';

        $lookupDto = new LookupDto($type, $id, $username);

        $this->assertEquals($type, $lookupDto->getType());
        $this->assertEquals($id, $lookupDto->getId());
        $this->assertEquals($username, $lookupDto->getUsername());
        $this->assertEquals('lookup_steam_id_123_username_username', $lookupDto->getCacheKey());
    }
}
