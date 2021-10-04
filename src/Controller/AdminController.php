<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_MANAGER")
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

        return $this->render('admin/edituser.html.twig' , [
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

     /**
     * @Route("/orders",name="orders", methods={"GET|POST"})
     *
     */    public function orderList(OrderRepository $orders): Response
     {
        return $this->render('admin/orders.html.twig', [
            'orders' => $orders->findAll()
        ]);
    }

}
