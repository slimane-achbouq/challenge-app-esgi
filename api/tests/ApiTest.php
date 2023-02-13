<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApiTest extends ApiTestCase
{
    /**
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testAuthentication()
    {
        $client = static::createClient();
        $authResponse = $client->request(
            'POST',
            '/auth',
            [
                'json' => [
                    'email' => 'slimane321@gmail.com',
                    'password' => 'slachslach',
                ]
            ]
        );

        $this->assertResponseIsSuccessful();
        $jwtToken = $authResponse->toArray()['token'];
        $this->assertNotNull($jwtToken);

        return $jwtToken;
    }

    /**
     * @depends testAuthentication
     * @param string $jwtToken
     */
    public function testCreateAnnonce(string $jwtToken)
    {
        $client = static::createClient();

        $uploadedFile = new UploadedFile(
            __DIR__.'/resources/annonce_img.jpeg',
            'annonce_img.jpeg'
        );

        $client->request(
            'POST',
            '/annonces',
            [
                'headers'           => [
                    'Content-Type' => 'multipart/form-data',
                    'Accept' => 'application/json'
                ],
                'auth_bearer'       => $jwtToken,
                'extra' => [
                    'files' => [
                        'file' => $uploadedFile,
                    ],
                ],
                'json' => [
                    'title'         => 'test annonce',
                    'description'   => 'test description',
                    'price'         => 20,
                    'isPerHour'     => true
                ],
            ]
        );

        $this->assertResponseIsSuccessful();
    }
}
