<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findall();
        $products = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findall();
        $categories = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();

        return $this->render('default/index.html.twig', [
            'posts'=> $posts,
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * @IsGranted("ROLE_MANAGER")
     * @Route("/create_post",name="post_create", methods={"GET|POST"})
     *
     */   
    public function create(Request $request): Response
    {
        $post = new Post();
        $post->setCreatedAt(new \DateTime());
        $post->setUser($this->getUser());

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
 

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success',"Votre post a été créer ");

            return $this->redirectToRoute('post_list');
        }

        #passer le formulaire à la vue
        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    /**
     * @IsGranted("ROLE_MANAGER")
     * @Route("/list_post", name="post_list")
     */
    public function list(PostType $posts): Response
    {     $posts = $this->getDoctrine()
        ->getRepository(Post::class)
        ->findall();
        return $this->render('post/list_posts.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * Modifier une actualité
     * @IsGranted("ROLE_MANAGER")
     * @Route("/modified_post/{id}", name="post_modified", methods={"GET|POST"})
     */
    public function editPost(Post $post, Request $request) {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('message','post modifié avec succès');
            return $this->redirectToRoute('post_list');
        }

        return $this->render('post/create.html.twig' , [
            'form' => $form->createView()
        ]);
    }


    /**
     * @IsGranted("ROLE_MANAGER")
     * @Route("/delete/{id}", name="post_delete")
     */
    public function remove(Post $posts)
    {
        // recuperation de l'entity manager
        $items = $this->getDoctrine()->getManager();
        $items->remove($posts);
        $items->flush();

        $this->addFlash('message', 'post supprimée');

        return $this->redirectToRoute('post_list');

    }



    /**
     * @Route("/cgv", name="cgv", methods={"GET"})
     */

    public function cgv(): Response
    {
        return $this->render('default/cgv.html.twig');
    }

    /**
     * @Route("/mention-legale", name="mention", methods={"GET"})
     */

    public function mention(): Response
    {
        return $this->render('default/mention_legale.html.twig');
    }

    /**
     * @Route("/plan-du-site", name="plan", methods={"GET"})
     */

    public function plan(): Response
    {
        return $this->render('default/plan_site.html.twig');
    }

}
