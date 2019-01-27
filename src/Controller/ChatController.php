<?php
/**
 * Created by PhpStorm.
 * User: Credo
 * Date: 26/1/2019
 * Time: 9:56 AM
 */

namespace App\Controller;


use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/home", name="chat_home")
     */
    public function homeAction(Request $request){
        $session = new Session();
        $userId = $session->get('userId');

        if(!$session->get('userId')){
           return $this->redirectToRoute('user_login');
        }

        $em = $this->getDoctrine()->getManager();
        $message = new Message();


        $form = $this->createForm(MessageType::class, $message);

        $messages = $em->getRepository(Message::class)->findAll();

        $user = $em->getRepository(User::class)->find($userId);

        return $this->render('maltemchat/home.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'messages' => $messages,
        ]);

    }

    /**
     * @Route("/message/new", name="message_new")
     */
    public function newAction(Request $request){
        $session = new Session();
        $message = new Message();
        $userId = $session->get('userId');


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($userId);

        $message->setUser($user);

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($message);
            $em->flush();

        }

        return $this->redirectToRoute('chat_home');
    }

    /**
     * @Route("/messages/ajax", name="message_index_ajax")
     */
    public function getMessagesViaAjax(){
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository(Message::class)->findAll();

        return $this->render('maltemchat/messagesViaAjax.html.twig', [
            'messages' => $messages,
        ]);
    }
}