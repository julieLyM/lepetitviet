<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Form\PostType;

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


        return $this->render('default/index.html.twig', [
            'posts'=>$posts
        ]);
    }

    /**
     * @Route("/create_post",name="create_post", methods={"GET|POST"})
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

            return $this->redirectToRoute('create_post');
        }

        #passer le formulaire à la vue
        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
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
