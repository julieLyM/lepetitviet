<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/products",name="products_")
 */     

class ProductsController extends AbstractController
{
    /**
     * @Route("/",name="index")
     */     
    public function index()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->render('products/category.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function category(Category $category): Response
    {
        return $this->render('products/product.html.twig', [
            'category'=>$category

        ]);
    }


    /**
     * @Route("/{category}/{slug}/{id}", name="detail" , methods={"GET"})
     * @param Product $product
     */
    public function productDetail(Product $product):Response
    {
        return $this->render('products/detailProduct.html.twig',[
            'product'=>$product
        ]);
    }
}



