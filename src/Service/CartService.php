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

    public function add($id)
    {
    $panier = $this->session->get('panier', []);
    if(!empty($panier[$id])){
        $panier[$id]++;
    }else{
        $panier[$id] = 1;
    }
    $this->session->set('panier', $panier);
    }

    public function delete($id)
    {
    $panier= $this->session->get('panier', []);

    if(!empty($panier[$id])){#s'il existe

        unset($panier[$id]);

    }

    $this->session->set('panier', $panier);
}

    public function remove()
    {
        return $this->session->remove('panier');
    }

    public function get()
    {
        return $this->session->get('cart');
    }
    
    public function getFullCart(){

    $panier = $this->session->get('panier', []);

    #enrichir les informations

    $panierWithData = [];

    foreach($panier as $id => $quantity){#a chaque fois qu'il boucle il rajoute une nouvelle entrée

                $panierWithData[] = [
                    'product'=> $this->productRepository->find($id),
                    'quantity'=>$quantity
                ];

            
        }
        return $panierWithData;
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

    public function getTotal()

        {
            $total = 0; #déclaration d'une variable pour calculer une variable

            foreach ($this->getFullCart() as $item){
                $total += $item['product']->getPrice() * $item['quantity'];

        }
            return $total;
        }



}