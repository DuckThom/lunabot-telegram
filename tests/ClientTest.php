<?php

namespace Tests;

use Bot\Client;

/**
 * Client test
 *
 * @package Tests
 */
class ClientTest extends TestCase
{
    const TOKEN = "blaat";

    /**
     * @test
     */
    public function checkIfBotIsTheTarget()
    {
        $client = new Client(self::TOKEN);

        $this->assertTrue($client->isTarget("/blaat@test_bot"));
        $this->assertTrue($client->isTarget("/blaat"));
        $this->assertFalse($client->isTarget("/blaat@foo_bot"));
    }
}