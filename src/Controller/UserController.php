<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $session = new Session();
            $session->start();
            $session->set('userId', $user->getId());

            return $this->redirectToRoute('chat_home');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/user/login", name="user_login")
     */
    public function loginAction(Request $request)
    {
        $form = $this->createForm(LoginType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $credentials = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy([
                'pseudo' => $credentials['pseudo'],
            ]);

            if(!$user){
                return $this->redirectToRoute('user_register');
            }

            $session = new Session();
            $session->start();
            $session->set('userId', $user->getId());

            return $this->redirectToRoute('chat_home');
        }

        return $this->render('user/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
