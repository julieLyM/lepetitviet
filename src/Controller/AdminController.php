<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Order;

use App\Form\EditUserType;
use App\Form\ProductType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin",name="admin_")
 *
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/",name="index")
     *
     */    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


//----------------------------------------------GESTION UTILISATEURS----------------------------------------------


    /**
     * @Route("/utilisateurs",name="utilisateurs")
     *
     */    public function usersList(UserRepository $users): Response
     {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll()
        ]);
    }

     /**
     * Modifier un utilisateur
     * 
     * @Route("/utilisateur/modifier/{id}", name="utilisateur_modifier", methods={"GET|POST"})
     */
    public function editUser(User $user, Request $request) {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message','utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/edit_user.html.twig' , [
            'userForm' => $form->createView()
        ]);
    }


    /** 
     * @Route("/utilisateur/{id}", name="utilisateur_supp")
     * @param Request $request
     * @return Response
     *
     */
    public function delete(User $user): Response
    {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('message','user supprimer');

        return $this->redirectToRoute('admin_utilisateurs');
    }

//----------------------------------------------GESTION COMMANDE----------------------------------------------


     /**
     * @Route("/orders",name="orders", methods={"GET|POST"})
     *
     */    
    public function orderList(OrderRepository $orders): Response
     {
        return $this->render('admin/orders.html.twig', [
            'orders' => $orders->findAll()
        ]);
    }


    //----------------------------------------------GESTION PRODUITS----------------------------------------------

    /**
     * @Route("/nos-produits", name="list_all_products", methods={"GET|POST"})
     */
    public function listProduct()
    {

        $items = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findall();


        return $this->render('products/list_all_products.html.twig', [
                'items'=>$items
        ]);
    }



    /**
     * @Route("/nos-produits/creation-produit", name="create_product", methods={"GET|POST"})
     */
    public function create(Request $request, SluggerInterface $slugger)

    {
        #Creation d'un nouvel produit vide
        $product = new Product();
        $product->setCreatedAt(new \DateTime());

        #remplacer par l'itulisateur actuel(ici, l'admin)
        $product->setUser($this->getUser());#l"utilisateur qui est connecté


        #CREATION DE FORMULAIRE

        $form = $this->createForm(ProductType::class, $product);


        #Permet a symfony de gérer les données saisies par l'utilisateur
        $form->handleRequest($request);

        #Si le formulaire est soumis et valide

        if($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();


            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid('', true).'.'.$image->guessExtension();


                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                   $this->addFlash('danger','une erreur est survenue durant le chargement de votre page');
                }


                $product->setImage($newFilename);
            }

            # Generation de l'alias à partir de l'article
            $product->setSlug(
                $slugger->slug(
                    $product->getName()
                )
                );

            # Insertion dans la base de données

            $em =$this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success','votre produit a été ajouté');

            return $this->redirectToRoute('admin_list_all_products');
        }


        return $this->render('products/create_product.html.twig', [
            'form'=> $form->createView()
        ]);

}

/**
 * @Route("/nos-produits/supprimer/{id}", name="delete_product")
 */
public function remove(Product $product)
{
    // recuperation de l'entity manager
    $items = $this->getDoctrine()->getManager();
    $items->remove($product);
    $items->flush();

    $this->addFlash('message', 'produit supprimée');

    return $this->redirectToRoute('admin_list_all_products');

}



    /**
     * @Route("/nos-produits/modification/{id}", name="modification_produit", methods={"GET|POST"})
     */
    public function modification(Request $request, Product $product, SluggerInterface $slugger){

        //Récupération du formulaire
        $form = $this->createForm(ProductType::class, $product);//Lien Objet géré par le formulaire -> Requête soumission du formulaire
        $form-> handleRequest($request);

        //si le formulaire à été soumis et est valide
        if($form->isSubmitted() && $form->isValid()){

            //enregistrement du produit dans la bdd
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();


            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid('', true).'.'.$image->guessExtension();


                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger','une erreur est survenue durant le chargement de votre page');
                }


                $product->setImage($newFilename);
            }

            # Generation de l'alias à partir de l'article
            $product->setSlug(
                $slugger->slug(
                    $product->getName()
                )
            );


            $em = $this->getDoctrine()->getManager();

            //inutile, l'objet provient de la BDD
            //$em->persist($produit);

            $em->flush();

            $this->addFlash('success',"Le produit à bien été modifié dans la base de donnée.");

        }

        //Génération du code HTML pour le formulaire créé
        $formView = $form->createView();

        //Affichage de la vue
        return $this->render('/products/create_product.html.twig', [

            'form'=>$formView
        ]);

    }



}
