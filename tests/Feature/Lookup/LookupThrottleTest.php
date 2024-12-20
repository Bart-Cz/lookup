<?php

namespace Tests\Feature\Lookup;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LookupThrottleTest extends TestCase
{
    public function test_lookup_throttle_works()
    {
        Cache::flush();

        $responseData = [
            'id' => '45454545',
            'username' => 'Tebex45',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.steam_url_for_id') . $responseData['id'];

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        // throttle set to 20 -> first 20 are successful
        for ($i = 0; $i < 20; $i++) {
            $this->getJson(route('lookup', ['type' => 'steam', 'id' => $responseData['id']]))->assertSuccessful();
        }

        // 21st should 429
        $this->getJson(route('lookup', ['type' => 'steam', 'id' => $responseData['id']]))->assertStatus(429);

        Cache::flush();
        }
}
