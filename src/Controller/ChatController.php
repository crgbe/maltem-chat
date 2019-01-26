<?php
/**
 * Created by PhpStorm.
 * User: Credo
 * Date: 26/1/2019
 * Time: 9:56 AM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homeAction(){
        return $this->render('maltem_chat/home.html.twig');
    }
}