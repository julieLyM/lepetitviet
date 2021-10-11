<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


 /**
 * @Route("/cart",name="cart_")
 */     
class CartController extends AbstractController
{
    /**
     * @Route("/",name="index")
     */      
    public function index(CartService $cartService): Response
    {
      
       $panierWithData = $cartService->getFullCart();
       $total = $cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
       ]);
    }

    /**
     * @Route("/add/{id}",name="add")
     */      
    public function add($id, CartService $cartService)
    {
        $cartService->add($id);

        return $this->redirectToRoute('cart_index');
      }

      
    /**
     * @Route("/decrease/{id}", name="decrease", methods={"GET|POST"})
     */
    public function decrease(CartService $cartService, $id)
    {
        $cartService->decrease($id);

        return $this->redirectToRoute('cart_index');
    }


    /**
     * @Route("/remove/{id}",name="remove")
     */      
    public function remove( CartService $cartService,  $id)
    {
        $cartService->remove($id);

        return $this->redirectToRoute('cart_index');
    }


    /**
     * @Route("/remove",name="remove_all")
     */      
    
    public function removeAll(SessionInterface $session) {
        $session->remove("panier");
        
       return $this->redirectToRoute('cart_index');
    }
    

}
