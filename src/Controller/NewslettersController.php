<?php

namespace App\Controller;

use App\Entity\Newsletters\NewsLetters;
use App\Entity\Newsletters\Users;
use App\Form\NewslettersType;
use App\Form\NewslettersUsersType;
use App\Repository\Newsletters\NewsLettersRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/newsletters", name="newsletters_")
 */

class NewslettersController extends AbstractController
{
/**
 * @Route("/", name="home")
 */
public function index(Request $request, MailerInterface $mailer): Response
    {

        $user = new Users();
        $form = $this->createForm(NewslettersUsersType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());

            $user->setValidationToken($token);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $email = (new TemplatedEmail())
            ->from('newsletter@site.fr')
            ->to($user->getEmail())
            ->subject('inscription à la newsletter')
            ->htmlTemplate('emails/inscription.html.twig')
            ->context(compact('user','token'));

            $mailer->send($email);

            $this->addFlash('message', 'Inscription en attente de validation');
            return $this->redirectToRoute('index');
        }

        return $this->render('newsletters/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
 * @Route("/confirm/{id}/{token}", name="confirm")
 */
    public function confirm(Users $user, $token): Response 
    {
        if($user->getValidationToken() != $token){
            throw $this->createNotFoundException('Page non trouvée');
        }

            $user->setIsValid(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Compte activé');
            return $this->redirectToRoute('index');


    }

/**
 * @IsGranted("ROLE_MANAGER")
 * @Route("/prepare", name="prepare")
 */
public function prepare(Request $request): Response
    {

        $newsletter = new NewsLetters();
        $form = $this->createForm(NewslettersType::class, $newsletter);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
 

            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            return $this->redirectToRoute('newsletters_list');
        }
        return $this->render('newsletters/prepare.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(NewslettersRepository $newsletters): Response
    {
        return $this->render('newsletters/list.html.twig', [
            'newsletters' => $newsletters->findAll()
        ]);
    }

     /**
     * @Route("/send/{id}", name="send")
     */
    public function send(Newsletters $newsletter, MailerInterface $mailer): Response
    {
        $users = $newsletter->getCategories()->getUsers();

        foreach($users as $user){
            if($user->getIsValid()){
                $email = (new TemplatedEmail())
                ->from('newsletter@site.fr')
                ->to($user->getEmail())
                ->subject($newsletter->getName())
                ->htmlTemplate('emails/newsletter.html.twig')
                ->context(compact('newsletter','user'));
                $mailer->send($email);
            }
        }

         $newsletter->setIsSent(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newsletter);
        $em->flush();

        return $this->redirectToRoute('newsletters_list');
    }

    /**
     * @Route("/unsubscribe/{id}/{newsletter}/{token}", name="unsubscribe")
     */
    public function unsubscribe(Users $user, Newsletters $newsletter, $token): Response
    {
        if($user->getValidationToken() != $token){
            throw $this->createNotFoundException('Page non trouvée');
        }

        $em = $this->getDoctrine()->getManager();

        if(count($user->getCategories()) > 1){
            $user->removeCategory($newsletter->getCategories());
            $em->persist($user);
        }else{
            $em->remove($user);
        }
        $em->flush();

        $this->addFlash('message', 'Newsletter supprimée');

        return $this->redirectToRoute('index');
    }

    /**
     * Modifier une newsletter
     * 
     * @Route("/modified/{id}", name="modified", methods={"GET|POST"})
     */
    public function editNews(Newsletters $newsletter, Request $request) {
        $form = $this->createForm(NewslettersType::class, $newsletter);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();

            $this->addFlash('message','utilisateur modifié avec succès');
            return $this->redirectToRoute('newsletters_list');
        }

        return $this->render('newsletters/prepare.html.twig' , [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function remove(Newsletters $newsletter)
    {
        // recuperation de l'entity manager
        $items = $this->getDoctrine()->getManager();
        $items->remove($newsletter);
        $items->flush();

        $this->addFlash('message', 'newsletter supprimée');

        return $this->redirectToRoute('newsletters_list');

    }

}