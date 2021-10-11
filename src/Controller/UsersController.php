<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Form\EditUserType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UsersController extends AbstractController
{
    /**
     * @Route("/users",name="users")
     *
     */    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * 
     * @Route("/user/edit/{id}", name="edit_profil", methods={"GET|POST"})
     */
    public function editUser(User $user, Request $request) {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message','utilisateur modifié avec succès');
            
            return $this->redirectToRoute('users');
        }

        return $this->render('users/edit_profil.html.twig' , [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/order/{id}",name="user_order", methods={"GET|POST"})
     *
     */    public function userOrder(OrderRepository $orders, $id): Response
     {
         $orders = $this->getDoctrine()
         ->getRepository(Order::class)
         ->findBy(array('id' => $id));
        //  dd($orders);
        return $this->render('users/order-user.html.twig', [
            'orders' => $orders]);
    }

}
