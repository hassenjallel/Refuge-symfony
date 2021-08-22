<?php

namespace AssoBundle\Controller;

use AssoBundle\Entity\chatbot;
use AssoBundle\Entity\message;
use AssoBundle\Entity\question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use AssoBundle\Form\messageType;




use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @property \DateTime startDate
 */
class DefaultController extends Controller
{
    /**
     * @Route("/Asso")
     */
    public function indexAction()
    {
        return $this->render('@Asso/Default/home.html.twig');

    }

    public function chatbotAction()
    {
       // sendNotification();
        return $this->render('@Asso/Default/chatbot.html.twig');
    }
    public function index1Action($id)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->find($id);

        return $this->render('@Asso/Default/message2.html.twig' ,array(
            'users' => $users));
    }

    public function showfamilleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findusersbyrole("ROLE_FAMILLE");
        $users  = $this->get('knp_paginator')->paginate(
            $users,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );
        return $this->render('@Asso/Default/showasso2.html.twig', array(
            'users' => $users
        ));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $users = $em->getRepository(User::class)->findEntitiesByString1Asso($requestString);
        if (!$users) {
            $result['entities']['error'] = "Aucun resultat";
        } else {
            $result['entities'] = $this->getRealEntities1($users);
        }
        return new Response(json_encode($result));
    }
    public function profileUserAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->getuserdatabyUsername($username);

        return $this->render('@Asso/Default/ProfileUser.html.twig', array(
            'users' => $users,
        ));
    }
    public function getRealEntities1($entities)
    {
        foreach ($entities as $users) {
            $realEntities[$users->getUsername()] = [$users->getUsername()];
        }
        return $realEntities;
    }

public function listcontactAction(){

    $em = $this->getDoctrine()->getManager();
    $loginEnvoi = $this->container->get('security.token_storage')->getToken()->getUser();


    $login = $em->getRepository(message::class)->findloginEnvoi($loginEnvoi ->getUsername());
   // $login2 = $em->getRepository(message::class)->findloginEnvoi2($user);

    return $this->render('@Asso/Default/message2.html.twig' ,array(
        'logins' => $login   ));
}




 public function ajoutMessage2Action(Request $request,$idMessage , $loginEnvoi , $loginRecep ){

     $em = $this->getDoctrine()->getManager();
     $login = $em->getRepository(message::class)->findloginEnvoi($loginEnvoi);
     $img = $em->getRepository(message::class)->img($idMessage);

     $message = $em->getRepository(message::class)-> getMesage( $loginEnvoi ,$loginRecep);


     $message2 = new message();
     $form = $this->createForm(messageType::class);
     $form = $form->handleRequest($request);
     if($form->isSubmitted())
     {
         $entityManager =$this->getDoctrine()->getManager();


         $message2 ->setIdMessage($idMessage);

         $message2 ->setLoginEnvoi($loginEnvoi);

         $message2->setLoginRecep($loginRecep);

         $message2->setMessage($request->get('msg'));
         $message2->setDate(new \DateTime('now'));
         $message2->setRole('Association');



         $message2->setIdRecep($idMessage);


         $entityManager->persist($message2);
         $entityManager->flush();


         return $this->redirectToRoute("messageaffiche" ,[ 'idMessage'=>$idMessage , 'loginEnvoi'=> $loginEnvoi,'loginRecep' => $loginRecep] );
     }
     return $this->render('@Asso/Default/message3.html.twig' ,array(
         'messages' => $message , 'logins' => $login,'loginRecep' =>$loginRecep , "form" => $form->createView() ));


 }


   /* public function modifier1Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $login = $em->getRepository(message::class)->findloginEnvoi();

        $message = $em->getRepository(message::class)-> getMesage($idMessage , $idRecep, $loginEnvoi , $loginRecep );

        if($request->isMethod('POST'))
        {
            $message->setIdMessage($idMessage);

            $message->setLoginEnvoi($loginEnvoi);

            $message->setLoginRecep($loginRecep);

            $message->setMessage($request->get('message'));
            $message->setRole('Famille');

            $message->setDate("now");

            $message->setIdRecep($idRecep);
            $em->flush();
            return $this->redirectToRoute("messageaffiche");
        }
        return $this->render('@Asso/Default/message3.html.twig',array('message'=>$message , 'logins' => $login ));
    }*/
   public function ajoutMessageAction(Request $request, $loginEnvoi , $idMessage ,$loginRecep){
      // $message2 = new message();

        $em = $this->getDoctrine()->getManager();
        $login = $em->getRepository(message::class)->findloginEnvoi($loginEnvoi);

       // $login2 = $em->getRepository(message::class)->findloginEnvoi2();
      //  $idRecep[0]=$em->getRepository(message::class)->findIdByUsername($loginRecep);

        $message = $em->getRepository(message::class)-> getMesage(  $loginEnvoi  ,$loginRecep);
        $message2 = $em->getRepository('AssoBundle:message')->findAll();
        if($request->isMethod('POST'))
        {
          //  if (isset($message2 [0])) {
                // Do bad things to the votes array


                $message2 ->setIdMessage($idMessage);

                $message2 ->setLoginEnvoi($request->get('loginEnvoi') );

                $message2->setLoginRecep( $request->get('loginRecep'));

                $message2->setMessage($request->get('msg'));
                $message2->setDate(new \DateTime('now'));
                $message2->setRole('Association');



               $message2->setIdRecep($request->get('idMessage'));
       //    }
            $em->flush();




            return $this->redirectToRoute("messageaffiche" ,[ 'idMessage'=>$idMessage , 'loginEnvoi'=> $loginEnvoi,'loginRecep' => $loginRecep] );
        }
        return $this->render('@Asso/Default/message3.html.twig' ,array(
            'messages' => $message , 'logins' => $login, 'messages2' => $message2 ));


    }
    public function chatAction(Request $request)
        {
            $em = $this->getDoctrine()->getManager();
            $requestString = $request->get('q');
            $msg = $em->getRepository(chatbot::class)->findanswer($requestString);

            if (!$msg) {
                $result['entities']['error'] = "Aucun resultat";
            } else {
                $result['entities'] = $this->getRealEntities3($msg);
            }
            return new Response(json_encode($result));
        }

    public function getRealEntities2($entities)
    {
        foreach ($entities as $msg) {
            $realEntities[$msg->getmsg($entities)] = [$msg->getmsg($entities)];
        }
        return $realEntities;
    }

    public function getRealEntities3($entities)
    {
        foreach ($entities as $msg) {
            $realEntities[$msg->getMessagechatbot()] = [$msg->getMessagechatbot()];
        }
        return $realEntities;
    }

    /*
     *  if (isset($message2 [0])) {
                // Do bad things to the votes array

                $message2[1] ->setIdMessage($request->get('idMessage') );

                $message2 [1]->setLoginEnvoi($request->get('loginEnvoi') );

                $message2[1]->setLoginRecep( $request->get('loginRecep'));

                $message2[1]->setMessage($request->get('msg'));
                $message2[1]->setDate(new \DateTime('now'));
                $message2[1]->setRole('Famille');



               $message2[1]->setIdRecep($request->get('idMessage'));
            }
*/

    public function pdfAction( $loginEnvoi , $loginRecep )
    {

        $em = $this->getDoctrine()->getManager();

        $message = $em->getRepository(message::class)-> getMesage( $loginEnvoi ,$loginRecep);

        $snappy = $this->get('knp_snappy.pdf');
        $filename = 'myFirstSnappyPDF';

        // use absolute path !
        //$pageUrl = $this->generateUrl('pdf_homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL);
        $pageUrl=$this->render('@Asso/Default/pdf.html.twig',array(  'messages' => $message  ,'loginEnvoi' => $loginEnvoi,'loginRecep' => $loginRecep));

        return new Response(
            $snappy->getOutputFromHtml($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }



}
