<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class CreateStripeSessionController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    #[Route(
        path: '/stripe/getSession',
        name: 'post_stripe_session',
        methods: ['POST'],
    )]
    public function __invoke()
    {
        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET']);
        $request = $this->requestStack->getCurrentRequest();

        $checkout_session = $stripe->checkout->sessions->create([
            'success_url' => $_ENV['FRONT_URL'] . '/challenge-app-esgi/requests/pay/success/' . $request->get('token') . '/' . $request->get('request_id'),
            'cancel_url' => $_ENV['FRONT_URL'] . '/challenge-app-esgi/requests' . $request->get('request_id'),
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => (int)$request->get('price') * 100,
                    'product_data' => [
                        'name' => $request->get('title'),
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
        ]);

        return new Response(json_encode($checkout_session));
    }
}
