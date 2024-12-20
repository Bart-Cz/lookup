<?php

namespace Tests\Feature\Lookup;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LookupSteamTest extends TestCase
{
    public function test_when_steam_and_only_username_it_fails()
    {
        Http::fake();

        $response = $this->getJson(route('lookup', ['type' => 'steam', 'username' => 'test']));

        $this->assertEquals('Steam only supports IDs', $response['error']);
    }

    public function test_when_steam_and_no_username_and_no_id_it_fails()
    {
        Http::fake();

        $response = $this->getJson(route('lookup', ['type' => 'steam']))->assertInvalid(['username', 'id']);

        $this->assertEquals('The id field is required when username is not present.', $response['errors']['id'][0]);
        $this->assertEquals('The username field is required when id is not present.', $response['errors']['username'][0]);
    }

    public function test_steam_with_id()
    {
        $responseData = [
            'id' => '1111111111',
            'username' => 'Tebex',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.steam_url_for_id') . $responseData['id'];

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $response = $this->getJson(route('lookup', ['type' => 'steam', 'id' => $responseData['id']]))
            ->assertSuccessful();

        $this->assertEquals($responseData['username'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals($responseData['meta']['avatar'], $response['avatar']);
    }

    public function test_steam_with_id_and_username_falls_back_on_id()
    {
        $responseData = [
            'id' => '1111111112',
            'username' => 'Tebex2',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.steam_url_for_id') . $responseData['id'];

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $response = $this->getJson(route('lookup', [
                'type' => 'steam',
                'id' => $responseData['id'],
                'username' => strtolower($responseData['username'])
            ]))
            ->assertSuccessful();

        $this->assertEquals($responseData['username'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals($responseData['meta']['avatar'], $response['avatar']);
    }

    public function test_steam_it_errors_when_returned_api_call_data_does_not_match()
    {
        $responseData = [
            'differentid' => '1111111113',
            'differentusername' => 'Tebex3',
            'differentmeta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.steam_url_for_id') . $responseData['differentid'];

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $response = $this->getJson(route('lookup', [
                'type' => 'steam',
                'id' => $responseData['differentid']]))
            ->assertStatus(500);

        $this->assertEquals('Unexpected API response format.', $response['error']);
    }
}
