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
        $url = 'https://fastly.picsum.photos/id/146/200/300.jpg?hmac=SbgvjELdBXByeF4AV3A384JFrIvNAhXlCtOmep9DmKE';
        $img = __DIR__.'/resources/annonce_img.jpg';
        file_put_contents($img, file_get_contents($url));
        $client = static::createClient();

        $uploadedFile = new UploadedFile(
            __DIR__.'/resources/annonce_img.jpg',
            'annonce_img.jpg'
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
