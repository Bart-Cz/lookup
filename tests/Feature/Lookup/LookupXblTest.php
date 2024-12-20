<?php

namespace Tests\Feature\Lookup;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LookupXblTest extends TestCase
{
    public function test_xbl_with_username()
    {
        $responseData = [
            'id' => '21111111111111',
            'username' => 'Tebex10',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.xbl_url_for_username') . strtolower($responseData['username']) . "?type=username";

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $username = strtolower($responseData['username']);

        $response = $this->getJson(route('lookup', ['type' => 'xbl', 'username' => $username]))
            ->assertSuccessful();

        $this->assertEquals($responseData['username'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals($responseData['meta']['avatar'], $response['avatar']);
    }

    public function test_xbl_with_id()
    {
        $responseData = [
            'id' => '211111111111112',
            'username' => 'Tebex11',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.xbl_url_for_id') . $responseData['id'];

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $response = $this->getJson(route('lookup', ['type' => 'xbl', 'id' => $responseData['id']]))
            ->assertSuccessful();

        $this->assertEquals($responseData['username'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals($responseData['meta']['avatar'], $response['avatar']);
    }

    public function test_xbl_with_username_and_id_falls_back_on_id()
    {
        $responseData = [
            'id' => '211111111111113',
            'username' => 'Tebex13',
            'meta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.xbl_url_for_username') . strtolower($responseData['username']) . "?type=username";

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $username = strtolower($responseData['username']);

        $response = $this->getJson(route('lookup', [
                'type' => 'xbl',
                'username' => $username,
                'id' => $responseData['id']
            ]))
            ->assertSuccessful();

        $this->assertEquals($responseData['username'], $response['username']);
        $this->assertEquals($responseData['id'], $response['id']);
        $this->assertEquals($responseData['meta']['avatar'], $response['avatar']);
    }

    public function test_when_xbl_and_no_username_and_no_id_it_fails()
    {
        Http::fake();

        $response = $this->getJson(route('lookup', ['type' => 'xbl']))->assertInvalid(['username', 'id']);

        $this->assertEquals('The id field is required when username is not present.', $response['errors']['id'][0]);
        $this->assertEquals('The username field is required when id is not present.', $response['errors']['username'][0]);
    }

    public function test_xbl_it_errors_when_returned_api_call_data_does_not_match()
    {
        $responseData = [
            'differentid' => '211111111111113',
            'differentusername' => 'Tebex13',
            'differentmeta' => [
                'avatar' => 'https://some.test.avatar/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg'
            ],
        ];

        $url = config('lookup.xbl_url_for_username') . strtolower($responseData['differentusername']) . "?type=username";

        Http::fake([
            $url => Http::response($responseData, 200, []),
        ]);

        $username = strtolower($responseData['differentusername']);

        $response = $this->getJson(route('lookup', [
                'type' => 'xbl',
                'username' => $username
            ]))
            ->assertStatus(500);

        $this->assertEquals('Unexpected API response format.', $response['error']);
    }
}
