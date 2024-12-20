<?php

namespace Tests\Feature\Lookup;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LookupMinecraftTest extends TestCase
{
    public function test_minecraft_with_id()
    {
        $responseData = [
            'id' => '1111111111111111',
            'name' => 'Tebex',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.minecraft_url_for_id') . $responseData['id'];

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $response = $this->getJson(route('lookup', ['type' => 'minecraft', 'id' => $responseData['id']]))
            ->assertSuccessful();

        $this->assertEquals($responseData['name'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals(config('lookup.minecraft_avatar_base_url') . $responseData['id'], $response['avatar']);
    }

    public function test_minecraft_with_username()
    {
        $responseData = [
            'id' => '1111111111111112',
            'name' => 'Tebex2',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.minecraft_url_for_username') . strtolower($responseData['name']);

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);


        $response = $this->getJson(route('lookup', ['type' => 'minecraft', 'username' => strtolower($responseData['name'])]))->json();

        $this->assertEquals($responseData['name'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals(config('lookup.minecraft_avatar_base_url') . $responseData['id'], $response['avatar']);
    }

    public function test_minecraft_with_id_and_username_it_falls_back_on_it()
    {
        $responseData = [
            'id' => '1111111111111113',
            'name' => 'Tebex3',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.minecraft_url_for_id') . $responseData['id'];

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $response = $this->getJson(route('lookup', ['type' => 'minecraft', 'id' => $responseData['id'], strtolower($responseData['name'])]))
            ->assertSuccessful();

        $this->assertEquals($responseData['name'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals(config('lookup.minecraft_avatar_base_url') . $responseData['id'], $response['avatar']);
    }

    public function test_minecraft_no_id_no_username()
    {
        $responseData = [
            'id' => '1111111111111114',
            'name' => 'Tebex4',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.minecraft_url_for_id') . '*';

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $response = $this->getJson(route('lookup', ['type' => 'minecraft']))->assertInvalid(['username', 'id']);

        $this->assertEquals('The id field is required when username is not present.', $response['errors']['id'][0]);
        $this->assertEquals('The username field is required when id is not present.', $response['errors']['username'][0]);
    }

    public function test_minecraft_it_errors_when_returned_api_call_data_does_not_match()
    {
        $responseData = [
            'differentId' => '1111111111111115',
            'differentName' => 'Tebex5',
            'differentMeta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.minecraft_url_for_id') . '*';

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $response = $this->getJson(route('lookup', ['type' => 'minecraft', 'id' => $responseData['differentId']]))
            ->assertStatus(500);

        $this->assertEquals('Unexpected API response format.', $response['error']);
    }
}
