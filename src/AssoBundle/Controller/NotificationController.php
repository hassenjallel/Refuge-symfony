<?php

namespace AssoBundle\Controller;

use AssoBundle\Entity\chatbot;
use AssoBundle\Entity\message;
use AssoBundle\Entity\question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use AssoBundle\Form\messageType;

/**
 * @property \DateTime startDate
 */
class NotificationController extends Controller
{
public function displayAction(){

    $notifications = $this->getDoctrine()->getManager()->getRepository('AssoBundle:Notification')->findAll();
    return $this ->render('@Asso/Default/notifications.html.twig'
    ,array('notifications' => $notifications));
}


}
