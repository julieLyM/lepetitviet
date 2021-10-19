<?php

namespace App\Controller;

use App\Entity\Order;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/order/create-session/{reference}", name="create_session", methods={"GET|POST"})
     */
    public function index($reference)
    {
        $YOUR_DOMAIN = 'http://localhost:8000';
        $products_stripe = [];
        $order = $this->getDoctrine()
                ->getRepository(Order::class)
                ->findOneByReference($reference);

        foreach ($order->getDetails()->getValues() as $item){
            $products_stripe[] = [

                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getProduct()->getPrice()*100,
                    'product_data' => [
                        'name' => $item->getProduct()->getName(),
                    ],
                ],
                'quantity' => $item->getQuantity(),
            ];
        }

        Stripe::setApiKey('sk_test_51JfKIJIKmyGlsl8YOWybUWrg1ugG8nBq6bmhOHcKWRlEFaitNo8BHWI3KdpFLFYMYSWIqukeDTQtT5eVYaLl9Fzx00vPv12toc');

        $checkout_session = Session::create([
            'customer_email'=>$this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [[
                $products_stripe
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/order/validate/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/order/cancel/{CHECKOUT_SESSION_ID}',
        ]);

        $order->SetStripeSessionId($checkout_session->id);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

     $response = new JsonResponse(['id' => $checkout_session->id]);
     return $response;
    }
}
