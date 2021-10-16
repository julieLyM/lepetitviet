<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Service\CartService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


 /**
 * @Route("/order",name="order_")
 */   
class OrderController extends AbstractController
{
    /**
     * @Route("/",name="index")
     */   
    public function index(CartService $cartService)
    {

            $date = new \DateTime();

            $order = new Order();
            $reference = $date->format('dmy').'-'.uniqid('', true);
            $order->setReference($reference);
            $order->setStatus(0);
            $order->setAmount($cartService->getTotal());
            $order->setCreatedAt($date);
            $order->setUser($this->getUser());#l'utilisateur en cours

            $em =$this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            //Enregistrer mes produits OrderDetails()
            //pour chaque produit du va iterer

            foreach ($cartService->getFullCart() as $item)#Sur tout le panier qu'on récupère
            {
                $orderDetails = new OrderDetails();
                $orderDetails->setUserOrder($order);
                $orderDetails->setQuantity($item['quantity']);
                $orderDetails->setProduct($item['product']);

                $em =$this->getDoctrine()->getManager();

                $em->persist($orderDetails);
            }

            $em->flush();

            return $this->render('order/index.html.twig', [
                'cart'=>$cartService->getFullCart(),
                'order'=>$order,
                'reference'=>$order->getReference()#On passe la variable réference pour pouvoir y avoir accés et l'utiliser dans la recherche de la commande liée au paiement
            ]);


        }

    /**
     * @Route("/validate/{stripeSessionId}", name="validate", methods={"GET|POST"})
     */
    public function paymentSuccess(CartService $cartService, $stripeSessionId)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        #si la commande n'existe pas et si l'utilisateur n'est pas celui qui a passé la commande=>redirection(sécurité)
        if(!$order || $order->getUser() != $this->getUser()){

            return $this->redirectToRoute('cart_index');
        }
        #Si le statut de la commande est 0 => n'est pas encore payée
        if($order->getStatus() == 0){

            #On remove le panier(on a besion d'importer la class Cartservice pour pouvoir supprimer le panier)
            $cartService->remove($stripeSessionId);

            #On change la statut de la commande au statut suivant=>on envoie dans la base de données par la suite passant le statut à 1(Payée)
            $order->setStatus(1);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            
            #Envoie de mail de confirmation(à faire)
            // $notification->sendResponseOrder();
            
        }
        
        #Afficher les information à l'utilisateur
        return $this->render('order/orderSuccess.html.twig', [
            'order' => $order
        ]);
    }

    /**
     * @Route("/cancel/{stripeSessionId}", name="cancel", methods={"GET|POST"})
     */

    public function paymentCancel($stripeSessionId)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser()){#sécurité

            return $this->redirectToRoute('order_cancel');

        }

        #envoi email à l'utilisateur =>paiement n'est pas passé
        return $this->render('order/orderCancel.html.twig',[
            'order' => $order
        ]);
    }

}
