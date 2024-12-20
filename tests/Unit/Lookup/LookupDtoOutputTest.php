<?php

namespace Tests\Unit\Lookup;

use App\Objects\LookupDtoOutput;
use PHPUnit\Framework\TestCase;

class LookupDtoOutputTest extends TestCase
{
    public function test_dto()
    {
        $avatar = 'https://fake.website.photos/300/300';
        $id = '123';
        $username = 'username';

        $lookupDtoOutput = new LookupDtoOutput($id, $username, $avatar);

        $array = [
            'id' => $id,
            'username' => $username,
            'avatar' => $avatar,
        ];

        $this->assertEquals($array, $lookupDtoOutput->toArray());
    }
}
