<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ApiTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $authResponse = $client->request(
            'POST',
            '/auth',
            ['json' => [
                'email' => 'slimane321@gmail.com',
                'password' => 'slachslach',
            ]]);

        $this->assertResponseIsSuccessful();
        $this->assertNotNull($authResponse->toArray()['token']);
    }
}
