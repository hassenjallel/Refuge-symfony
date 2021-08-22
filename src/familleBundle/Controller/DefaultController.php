<?php

namespace familleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use familleBundle\Entity\message;
use familleBundle\Form\messageType;



/**
 * @property \DateTime startDate
 */
class DefaultController extends Controller
{
    /**
     * @Route("/famille")
     */
    public function indexAction()
    {
        return $this->render('@famille/Default/home.html.twig');
    }


    public function index1Action($id)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->find($id);

        return $this->render('@famille/Default/message2.html.twig' ,array(
            'users' => $users));
    }

    public function showAssoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findusersbyrole("ROLE_ASSOCIATION");
        $users  = $this->get('knp_paginator')->paginate(
            $users,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );
        return $this->render('@famille/Default/showfamille.html.twig', array(
            'users' => $users
        ));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $users = $em->getRepository(User::class)->findEntitiesByString1($requestString);
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

        return $this->render('@famille/Default/ProfileUser.html.twig', array(
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

    public function listcontactAction($loginEnvoi){

        $em = $this->getDoctrine()->getManager();

        $login = $em->getRepository(message::class)->findloginEnvoi($loginEnvoi);
        return $this->render('@famille/Default/message2.html.twig' ,array(
            'logins' => $login  ));
    }
    public function ajoutMessageAction(Request $request, $loginEnvoi , $idMessage ,$loginRecep){

        $em = $this->getDoctrine()->getManager();
        $login = $em->getRepository(message::class)->findloginEnvoi($loginEnvoi);

        // $login2 = $em->getRepository(message::class)->findloginEnvoi2();
        //  $idRecep[0]=$em->getRepository(message::class)->findIdByUsername($loginRecep);

        $message = $em->getRepository(message::class)-> getMesage(  $loginEnvoi  ,$loginRecep);
        $message2 = $em->getRepository(message::class)->findOneBy(['loginEnvoi' => $loginEnvoi]);

        if($request->isMethod('POST'))
        {
            // if (isset($message [0])) {
            // Do bad things to the votes array

            $message2 ->setIdMessage($request->get('idMessage') );

            $message2 ->setLoginEnvoi($request->get('loginEnvoi') );

            $message2->setLoginRecep( $request->get('loginRecep'));

            $message2->setMessage($request->get('msg'));
            $message2->setDate(new \DateTime('now'));
            $message2->setRole('Famille');



            $message2->setIdRecep($request->get('idMessage'));
            //     }

            $em->flush();
            //  return new Response(json_encode($message));{idRecep}/{loginEnvoi}/{loginRecep}

            // return new JsonResponse(['media' => $media->getPath()]);


            return $this->redirectToRoute("messageaffichefam" ,[ 'idMessage'=>$idMessage , 'loginEnvoi'=> $loginEnvoi,'loginRecep' => $loginRecep] );
        }
        return $this->render('@famille/Default/message3.html.twig' ,array(
            'messages' => $message ,'loginRecep' =>$loginRecep , 'logins' => $login, ));


    }

    public function ajoutMessage2Action(Request $request,$idMessage , $loginEnvoi , $loginRecep ){

        $em = $this->getDoctrine()->getManager();
        $login = $em->getRepository(message::class)->findloginEnvoi($loginEnvoi);

        $message = $em->getRepository(message::class)-> getMesage( $loginEnvoi ,$loginRecep);

        $img = $em->getRepository(message::class)-> getimg( $loginRecep);

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
            $message2->setRole('Famille');



            $message2->setIdRecep($idMessage);


            $entityManager->persist($message2);
            $entityManager->flush();


            return $this->redirectToRoute("messageaffichefam" ,[ 'idMessage'=>$idMessage , 'loginEnvoi'=> $loginEnvoi,'loginRecep' => $loginRecep] );
        }
        return $this->render('@famille/Default/message3.html.twig' ,array('img' => $img,
            'messages' => $message , 'logins' => $login,'loginRecep' =>$loginRecep , "form" => $form->createView() ));


    }

}
