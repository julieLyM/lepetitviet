<?php
namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;

    }


    public function add( $id) {
       // $session = $request->getSession();
        $panier = $this->session->get("panier", []);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;

        }
        $this->session->set("panier", $panier);


    }

    public function remove( $id) {

        $panier = $this->session->get("panier", []);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
       return $this->session->set("panier", $panier);
    }


    public function decrease($id)
    {
        $panier = $this->session->get('panier', []);
        //verifier si la quantité de notre produit est égal à 1

        if($panier[$id]> 1){
            //retirer une quantité
            $panier[$id]--;

        }else{
            //supprimer le produit
            unset($panier[$id]);

        }
        return $this->session->set('panier', $panier);#tu me reset le nouveau cart apres la suppression ou/et retrait d'un produit
    }


     public function getFullCart()  : array {
        $panier = $this->session->get('panier', []);
        $panierWithData = [];
        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity,
            ];
        }
        return $panierWithData;
     }
   
      public function getTotal()  : float {
        $total = 0;
        $panierWithData = $this->getFullCart();
        foreach($panierWithData as $item){
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        return $total;
      }

}