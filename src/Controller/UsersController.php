<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Form\EditUserType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/user",name="user_")
 */     
class UsersController extends AbstractController
{
    /**
     * @Route("/",name="index")
     *
     */    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * 
     * @Route("/edit/{id}", name="edit_profil", methods={"GET|POST"})
     */
    public function editUser(User $user, Request $request) {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message','utilisateur modifié avec succès');
            
            return $this->redirectToRoute('user');
        }

        return $this->render('user/edit_profil.html.twig' , [
            'userForm' => $form->createView()
        ]);
    }


   /**
     * @Route("/data/download",name="data_download")
     *
     */    public function userDataDownload(): Response
     {
         //definir les options pdf
         $pdfOptions = new Options();
         //police par defaut
         $pdfOptions->set('defaultfont', 'Arial');
         $pdfOptions->setIsRemoteEnabled(true);

         //instancie dompdf
         $dompdf = new Dompdf($pdfOptions);
         $context = stream_context_create([
             'ssl' => [
                 'verify_peer' => FALSE,
                 'verify_peer_name' => FALSE,
                 'allow_self_signed' => TRUE
             ]
         ]);
         $dompdf->setHttpContext($context);

         //generer html
         $html = $this->renderView('user/download.html.twig');

         $dompdf->loadHtml($html);
         $dompdf->setPaper('A4', 'portrait');
         $dompdf->render();

         //generer un nom de fichier
         $fichier = 'user-data-'. $this->getUser()->getId() . '.pdf';

         //envoyer le pdf au navigateur
         $dompdf->stream($fichier, [
             'Attachment' => true
         ]);

        return new Response();
    }

    /**
     * @Route("/order/{id}",name="order", methods={"GET|POST"})
     *
     */    public function userOrder(OrderRepository $orders, $id): Response
     {
         $orders = $this->getDoctrine()
         ->getRepository(Order::class)
         ->findBy(array('id' => $id));
        //  dd($orders);
        return $this->render('user/order-user.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/bill/download",name="bill_download")
     *
     */    
    public function billDownload(): Response
     {
        //definir les options pdf
        $pdfOptions = new Options();
        //police par defaut
        $pdfOptions->set('defaultfont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        //instancie dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        //generer html
        $html = $this->renderView('user/bill-dl.html.twig');

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        //generer un nom de fichier
        $fichier = 'user-bill-data-'. $this->getUser()->getId() . '.pdf';

        //envoyer le pdf au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

       return new Response();
   }

}
