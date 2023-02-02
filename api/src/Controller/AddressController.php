<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AddressController extends AbstractController
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    public function __invoke(Request $request)
    {
        $address = $request->get('address');

        $response = $this->httpClient->request(
            'GET',
            'https://api-adresse.data.gouv.fr/search/',
            [
                'query' => [
                    'q' => $address,
                    'autocomplete' => 1
                ]
            ]
        );

        return $response->getContent();
    }
}
