<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * Main page 
     * @Route("/",name="index")
     *
     */
    public function index(): Response
    {

        return $this->render('default/index.html.twig', [
            'controller_name' => 'indexController',
        ]);
    }


    /**
     * @Route("/{slug}",name="default_category", methods={"GET"})
     */

   // public function category(Category $category): Response
  //  {
        //dd($category);
     //   return $this->render('default/category.html.twig', [
             //'posts' => $category->getPosts()
    //         'category' => $category
     //   ]);
//}

    /**
     * @Route("/{category}/{slug}_{id}.html",name="default_post", methods={"GET"})
     */

    // public function post(Post $post)
    // {
    //     return $this->render('default/post.html.twig',[
    //         'post' => $post
    //     ]);
    // }
}
