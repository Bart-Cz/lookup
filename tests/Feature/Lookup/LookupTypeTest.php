<?php

namespace Tests\Feature\Lookup;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LookupTypeTest extends TestCase
{
    public function test_when_type_not_provided()
    {
        Http::fake();

        $response = $this->getJson(route('lookup', ['username' => 'test']))
            ->assertInvalid('type');

        $this->assertEquals('The type field is required.', $response['errors']['type'][0]);
    }

    public function test_when_incorrect_type_not_provided()
    {
        Http::fake();

        $response = $this->getJson(route('lookup', ['type' => 'testtype', 'username' => 'test']))
            ->assertInvalid('type');

        $this->assertEquals('The selected type is invalid.', $response['errors']['type'][0]);
    }
}
