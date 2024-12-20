<?php

namespace Tests\Feature\Lookup;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Objects\LookupDtoOutput;
use App\Objects\LookupDto;
use Tests\TestCase;

// for testing purposes only minecraft used
class LookupCacheTest extends TestCase
{
    public function test_minecraft_no_id_no_username_cache()
    {
        $responseData = [
            'id' => '1111111111111111',
            'name' => 'Tebex',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = 'https://sessionserver.mojang.com/session/minecraft/profile/*';

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $lookupDtoOutput = new LookupDtoOutput($responseData['id'], $responseData['name'], $responseData['meta']['avatar']);

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn($lookupDtoOutput);

        $response = $this->getJson(route('lookup', ['type' => 'minecraft', 'id' => $responseData['id']]));

        $this->assertEquals($responseData['name'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals($responseData['meta']['avatar'], $response['avatar']);
    }

    public function test_minecraft_no_id_no_username_cache2()
    {
        Cache::flush();

        $responseData = [
            'id' => '1111111111111111',
            'name' => 'Tebex',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $lookupDto = new LookupDto('minecraft', $responseData['id'], null);

        $cacheKey = $lookupDto->getCacheKey();

        $url = 'https://sessionserver.mojang.com/session/minecraft/profile/*';

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $this->getJson(route('lookup', ['type' => 'minecraft', 'id' => $responseData['id']]));

        $this->assertTrue(Cache::has($cacheKey));

        Cache::flush();
    }
}
